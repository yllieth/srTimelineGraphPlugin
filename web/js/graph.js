/**
 * Crée le graphique en utilisant directement l'API google.
 *
 * @see http://code.google.com/apis/ajax/playground/
 * @param datas    (JSON)  Objet contenant les propriétés suivantes :
 * <ul>
 *  <li><code>datas.timestamps</code> : [OBLIGATOIRE] Tableau contenant les timestamps du graphique (abscisses)</li>
 *  <li><code>datas.values</code> : [OBLIGATOIRE] Objet contenant un ou plusieurs tableaux avec les valeurs du graphique (ordonnées)</li>
 *  <li><code>datas.milestone</code> : [FACULTATIF] Tableau contenant les timestamps du graphique</li>
 *  <li><code>datas.graphConfs</code> : [FACULTATIF] Tableau contenant les options de configuration du graphique</li>
 *  <li><code>datas.tableConfs</code> : [FACULTATIF] Tableau contenant les options de configuration du tableau de valeurs</li>
 * </ul>
 * @param  divId   Identifiant de la div dans laquelle le graphique sera affiché
 * @author Sylvain {16/05/2012}
 * @MAJ by Sylvain {10/12/2012}: factorisation + amélioration (prise en charge des options personnalisées)
 */
function timelineDrawer(datas, divId) {	
	var data = new google.visualization.DataTable();
	var options = {};
	
	data.addColumn('date', 'Date');			// date (abscisse)
	for(var courbe in datas.values){
		data.addColumn('number', courbe);	// valeur (ordonnée)
		data.addColumn('string', 'title1');	// titre annotation
		data.addColumn('string', 'text1');	// texte annotation
	}
	
	data.addRows(buildTab(datas, true));
	
	// prend en compte les options envoyées par l'action
	for (var option in datas.graphConfs) {
		// cas particulier des dates de début et de fin de zoom : il faut instancier un objet Date à partir un timestamp PHP
		if ((option == "zoomStartTime" || option == "zoomEndTime") && typeof(datas.graphConfs[option]) == "number") {
			datas.graphConfs[option] = new Date(datas.graphConfs[option]*1000);
		}
	}

	// génération du graphique
	var annotatedtimeline = new google.visualization.AnnotatedTimeLine(document.getElementById(divId));
	annotatedtimeline.draw(data, datas.graphConfs);
}

/**
 * Crée le tableau de valeurs du graphique en utilisant directement l'API google.
 *
 * @see http://code.google.com/apis/ajax/playground/
 * @param datas    (JSON)  Objet contenant les propriétés suivantes :
 * <ul>
 *  <li><code>datas.timestamps</code> : [OBLIGATOIRE] Tableau contenant les timestamps du graphique (abscisses)</li>
 *  <li><code>datas.values</code> : [OBLIGATOIRE] Objet contenant un ou plusieurs tableaux avec les valeurs du graphique (ordonnées)</li>
 *  <li><code>datas.milestone</code> : [FACULTATIF] Tableau contenant les timestamps du graphique</li>
 *  <li><code>datas.graphConfs</code> : [FACULTATIF] Tableau contenant les options de configuration du graphique</li>
 *  <li><code>datas.tableConfs</code> : [FACULTATIF] Tableau contenant les options de configuration du tableau de valeurs</li>
 * </ul>
 * @param  divTab  Identifiant de la div dans laquelle le graphique sera affiché
 * @author Sylvain 16/05/2012
 * @MAJ by Sylvain {10/12/2012}: factorisation + amélioration (prise en charge des options personnalisées)
 */
function timelineValues(datas, divTab){
	var data = new google.visualization.DataTable();
	data.addColumn('date', 'Date');
	for(var courbe in datas.values){
		data.addColumn('number', courbe);
	}

	data.addRows(buildTab(datas, false));

	// défini les options par défaut du graphique
	var options = {
		allowHtml            : true, 
		alternatingRowStyle  : true,		// applique un style différent pour les lignes paires et impaires
		page                 : 'enable',	// active la pagination des résultats
		pageSize             : 8,			// idéal pour l'affichage (pas d'assenceur)
		showRowNumber        : false,		// masque le numéro des lignes
		sortAscending        : false,		// du plus récent au plus ancien
		sortColumn           : 0,			// trie par date (première colonne)
		cssClassNames        : {			// personnalise le rendu
			tableCell : 'backend_table_tr_td',
			headerCell: 'backend_table_thead_tr_th'
		}
	};
	
	// prend en compte les options envoyées par l'action
	for (var option in datas.tableConfs) {
		// si la propriété par défaut n'existe pas, on l'ajoute
		if (options.hasOwnProperty(option)==false) {
			options[option]=datas.tableConfs[option];
		} else {
			// si l'option est définie par défaut mais qu'on souhaite changer la valeur, on écrase la valeur par défaut
			if (options[option]!=datas.tableConfs[option]) {
				options[option]=datas.tableConfs[option];
			}
		}
		
		if ((option === "formatter")) {
			// formatter des nombres 
			var number_formatter = new google.visualization.NumberFormat(datas.tableConfs[option]);
			var i = 1;
			for(var courbe in datas.values){
				number_formatter.format(data,i);
				i++;
			}
		}
	}
	
	// tableau de valeurs
	var table = new google.visualization.Table(document.getElementById(divTab));
	table.draw(data, options);
}

/**
 * Crée le tableau qui sert de base pour l'API de google servant à la génération du graphique, mais aussi à la création du tableau de données affichés.
 * 
 * Ce tableau a la forme suivante :
 * <pre>
 * +------------+---------+--------+----------+---------+--------+----------+---------+--------+----------+----
 * | Date       | Valeur1 | Titre1 | Legende1 | Valeur2 | Titre2 | Legende2 | Valeur3 | Titre3 | Legende3 | ...
 * +------------+---------+--------+----------+---------+--------+----------+---------+--------+----------+----
 * | 17/05/2012 | 10      | null   | null     | 11      | null   | null     | 12      | null   | null     |
 * | 16/05/2012 | 7       | null   | null     | 8       | null   | null     | 9       | null   | null     |
 * |            |         |        |          |         |        |          |         |        |          |
 * +------------+---------+--------+----------+---------+--------+----------+---------+--------+----------+----
 * </pre>
 * Ce tableau crée un graphique temporel, présentant 3 courbes ayant chacune 2 valeurs correspondantes au 16 et 17 mai 2012.<br/>
 * De plus, seules les colonens ValeurXX sont nécessaires pour lgénérer le tableau de valeurs. Le paramètre <code>withLegend</code> sert présicément à ajouter ou non ces colonnes.
 *
 *
 * @param datas    (JSON)  Objet contenant les propriétés suivantes :
 * <ul>
 *  <li><code>datas.timestamps</code> : [OBLIGATOIRE] Tableau contenant les timestamps du graphique (abscisses)</li>
 *  <li><code>datas.values</code> : [OBLIGATOIRE] Objet contenant un ou plusieurs tableaux avec les valeurs du graphique (ordonnées)</li>
 *  <li><code>datas.milestone</code> : [FACULTATIF] Tableau contenant les timestamps du graphique</li>
 *  <li><code>datas.graphConfs</code> : [FACULTATIF] Tableau contenant les options de configuration du graphique</li>
 *  <li><code>datas.tableConfs</code> : [FACULTATIF] Tableau contenant les options de configuration du tableau de valeurs</li>
 * </ul>
 * @param  withLengend boolean Indique si il faut générer un tableau avec les colonnes pour les annotations (pour le graphique) on sans ces colonnes.
 * @author Sylvain 16/05/2012
 * @MAJ by Sylvain {10/12/2012}: factorisation + amélioration (prise en charge des dates clefs)
 */
function buildTab(datas, withLegend){
	var plot = [];
	
	for(var i = 0 ; i < datas.timestamps.length ; i++){
		var timeData = [];
		// colonne date
		timeData.push(new Date(parseInt(datas.timestamps[i])*1000));	// note : PHP traite les timestamps en secondes et Javascript en milisecondes !
		for(var courbe in datas.values){
			if(withLegend == true){
				if(datas.milestones!=undefined){
					var datesClefs = milestonesBetween(datas.timestamps[i],datas.timestamps[i+1],datas.milestones);
					if (datesClefs!=undefined&&datesClefs.titre!=undefined&&datesClefs.legende!=undefined)
						timeData.push(datas.values[courbe][i], datesClefs.titre, datesClefs.legende);	// pour le graphique
					else 
						timeData.push(datas.values[courbe][i], null, null);	// pour le graphique
				}else timeData.push(datas.values[courbe][i], null, null);		// pour le graphique
			}else
				timeData.push(datas.values[courbe][i]);				// pour le tableau de valeurs
		}
		plot.push(timeData);
	}

	return plot;
}

/**
 * Recherche dans le tableau de dates clefs (Date::getMilestones()) celles qui ont lieu entre <code>start</code> et <code>end</code> qui sont deux timestamps.
 *
 * Si il y a plusieurs dates clef dans cet interval, elles sont fusionnées.
 * Une fois une date clef trouvée, elle n'est pas prise en compte par les itérations suivantes. Celat permet de ne la vois qu'une fois, sur la première courbe.
 * 
 * @return Object
 * @author Sylvain {03/12/2012}
 */
function milestonesBetween(start,end,milestones) {
	var dates = [];
	var fusion = {titre:"", legende:""};
	var time;
	
	// extraction des dates clefs
	for(var stone in milestones){
		time=parseInt(stone);
		if(time>=start&&time<=end){
			dates.push({timestamp:time,event:milestones[stone]});
			
			// suppression pour qu'elle ne soit affichée que sur une seule courbe
			delete milestones[stone];
		}
	}
	
	// retour
	if(dates.length <= 0){
		fusion.titre = null;
		fusion.legende = null;
	} else if(dates.length == 1){
		fusion.titre = dates[0].event;
		fusion.legende = formatDate(dates[0].timestamp);
	} else {
		for (var i=0;i<dates.length;i++) {
			fusion.legende += ", "+dates[i].event+" ("+formatDate(dates[i].timestamp)+")";
		}
		
		fusion.titre = ":";
		fusion.legende=fusion.legende.substring(2,fusion.legende.length);
	}
	
	return fusion;
}

/**
 * Cette fonction utilise l'API de google pour tracer un graphique temporel.<br/>
 * 
 * Si tout se passe bien, on appele drawVisualization() qui va afficher :
 * <ul>
 *  <li>afficher le graphique</li>
 *  <li>afficher la table des données</li>
 *  <li>(à faire) entregistrer les donnée en localStorage (pour un accès ultérieur plus rapide)</li>
 * </ul>
 * 
 * @param datas    (JSON)  Objet contenant les propriétés suivantes :
 * <ul>
 *  <li><code>datas.timestamps</code> : [OBLIGATOIRE] Tableau contenant les timestamps du graphique (abscisses)</li>
 *  <li><code>datas.values</code> : [OBLIGATOIRE] Objet contenant un ou plusieurs tableaux avec les valeurs du graphique (ordonnées)</li>
 *  <li><code>datas.milestone</code> : [FACULTATIF] Tableau contenant les timestamps du graphique</li>
 *  <li><code>datas.graphConfs</code> : [FACULTATIF] Tableau contenant les options de configuration du graphique</li>
 *  <li><code>datas.tableConfs</code> : [FACULTATIF] Tableau contenant les options de configuration du tableau de valeurs</li>
 * </ul>
 * @param divGraph (string) Identifiant de la div à mettre à jour avec le graphique
 * @param divTab   (string) Identifiant de la div qui contient le tableau de valeurs
 * @author Sylvain {16/05/2012}
 * @MAJ by Sylvain {24/08/2012}: localStorage
 * @maj by Sylvain {10/12/2012}: paramètre divId
 */
function timelineGrapher(datas,divGraph,divTab){
	if (datas instanceof Object){
		// vérifie si la div qui va contenir le graphique existe
		if ($('#'+divGraph)==undefined) {alert('div introuvable (id:'+divGraph+')');}
		
		// vérifie si la div a une taille et en définie une par défaut dans le cas contraire
		if ($("#"+divGraph).css('width')=="0px") {$("#"+divGraph).css('width',700);}
		if ($("#"+divGraph).css('height')=="0px") {$("#"+divGraph).css('height',250);}
		
		// controles des paramèters obligatoires
		if (datas.timestamps==undefined) {alert("Aucun timestamp");}
		if (datas.values==undefined) {alert("Aucune donnée");}

		// dessine le graphique
		timelineDrawer(datas,divGraph);

		// affiche le tableau de valeurs
		if ($('#'+divTab)!=undefined) {timelineValues(datas, divTab);}
		
	} else if (typeof(datas)=='string' && datas.substring(0,1) == '{' && datas.substring(datas.length-1,datas.length) == '}') {
		timelineGrapher(eval('(' + datas + ')'), divGraph, divTab)
	} else {
		// en cas de message (d'erreur) à afficher 
		$( "#"+divGraph ).html(datas);
	}
}






function formatDate(date) {
	if (typeof(date)=='number'&&parseInt(date)==date) {
		var strDate = new Date(date*1000);
		return formatDate(strDate);
	}
	
	if (date instanceof Date) {
		var annee = date.getFullYear();
		var mois = (date.getMonth() < 9) ? '0'+(date.getMonth()+1) : (date.getMonth()+1).toString();
		var jour = (date.getDate() < 10) ? '0'+date.getDate() : date.getDate().toString();
		
		return jour+' / '+mois+' / '+annee;
	}
}