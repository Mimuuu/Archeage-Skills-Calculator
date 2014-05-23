/*
	Archeage Skill Calculator
	2014/05/17
*/

var points = 23; // Maximum for Archeage at lvl 50
var mTop = '-42px'; // Height of half the skill's image

/* 
	Code template: 21000110001001001x30011100000010010x81100010100100110
	First number: Number of the skill tree
	2 to 12: Active skills inside that tree
	13 to end: Passive skills inside that tree 
*/


/* ====================
	LISTS RELATED
==================== */

/*
	Display the skills tree
	@el 	: 	HTML Element from the click (this)
*/
function tal_display(el) {
	var list = el.parentNode.parentNode.getElementsByTagName('div');
	for (var i=0; i<list.length; i++) {
		if (list[i].id != '') {
			if (list[i].style.display == 'inline') {
				restore(list[i]);
				list[i].style.display = 'none';
				unlock(list[i].id);
			}
			if (list[i].id == el.value) {
				list[i].style.display = 'inline';
				lock(el.value);
			}
		}
	}
}

/*
	Lock a skill tree in the other select when already selected in one
	@str 	: 	ID of the skill tree
*/
function lock(str) {
	var opt = document.getElementsByTagName('option');
	for (var i=0; i<opt.length; i++) {
		if (opt[i].value == str) {
			opt[i].disabled = true;
		}
	}
}

/*
	Unlock a skill tree when the user change in another
	@str 	: 	ID of the skill tree
*/
function unlock(str) {
	var opt = document.getElementsByTagName('option');
	for (var i=0; i<opt.length; i++) {
		if (opt[i].value == str) {
			opt[i].disabled = false;
		}
	}
}


/* ====================
	SKILLS RELATED
==================== */

/*
	Display the skill details
	@el 	: 	HTML Element from the mouse over (this)
*/
function displayStats(el) {
	el.parentNode.childNodes[2].style.display = 'inline';
}

/*
	Hide the skill details
	@el 	: 	HTML Element from the mouse out (this)
*/
function hideStats(el) {
	el.parentNode.childNodes[2].style.display = 'none';
}

/*
	Toggle the skill to add or remove it
	@el 	: 	HTML Element from the click (this)
*/
function toggleSkill(el) {
	var marginValue = el.getElementsByTagName('img')[0].style.marginTop;
	if (marginValue == mTop) {
		if (validRemove(el)) {
			points++;
			el.getElementsByTagName('img')[0].style.marginTop = '0px';
		} else {
			alert('You can\'t remove this skill yet');
		}
	} else {
		if (el.dataset.req) {
			if (nbElements(el) >= el.dataset.req) {
				el.getElementsByTagName('img')[0].style.marginTop = mTop;
				points--;
			} else {
				alert('You can\'t skill this yet');
			}
		} else {
			el.getElementsByTagName('img')[0].style.marginTop = mTop;
			points--;
		}
	}
	updatePoints();
}

/*
	Restore the state of a skill tree when you change from the select
	@el 	: 	DIV element representing the skill tree
*/
function restore(el) {
	var tmp = el.getElementsByTagName('img');
	for (var i=0; i<tmp.length; i++) {
		if (tmp[i].style.marginTop == mTop) {
			points++;
			updatePoints();
			tmp[i].style.marginTop = '0px';
		}
	}
}


/* ====================
	POINTS RELATED
==================== */

/*
	Update the skill points in the HTML
*/
function updatePoints() {
	document.getElementById('skillPoints').innerHTML = points;
}

/*
	Count the skills already added
	@el 	: 	HTML Element from the click (this)
*/
function nbElements(el) {
	var count = 0;
	var list = el.parentNode.parentNode.getElementsByTagName('img');
	for (var i=0; i<list.length; i++) {
		if (list[i].style.marginTop == mTop) {
			count++;
		}
	}
	return count;
}

/*
	Check if removing the skill don't mess with some requirements
	@el 	: 	HTML Element from the click (this)
*/
function validRemove(el) {
	var highestRequirement = 0;
	var list = el.parentNode.parentNode.getElementsByTagName('li');
	for (var i=0; i<list.length; i++) {
		if (list[i] != el && list[i].className == 'tal_passive' && list[i].childNodes[0].style.marginTop == mTop) {
			if (list[i].dataset.req > highestRequirement) {
				highestRequirement = list[i].dataset.req;
			}
		}
	}
	if (highestRequirement > (nbElements(el) - 2) && highestRequirement != 0) {
		return false;
	} else {
		return true;
	}
}


/* ====================
	URL / LINK RELATED
==================== */

/*
	Highlight the active skills from URL parameters
	@t 		: 	The parameter element for the trees (17 digits)
	@node 	: 	The HTML node that include the active skills elements
*/
function highlightActiveSkills(t, node) {
	for (var i=1; i<12; i++) {
		if (parseInt(t[i]) == 1) {
			var el = node.childNodes[i-1];
			var img = el.getElementsByTagName('img');
			img[0].style.marginTop = mTop;
			points--;
		}
	}
	updatePoints();
}

/*
	Highlight the passive skills from URL parameters
	@t 		: 	The parameter element for the trees (17 digits)
	@node 	: 	The HTML node that include the passive skills elements
*/
function highlightPassiveSkills(t, node) {
	for (var i=12; i<17; i++) {
		if (parseInt(t[i]) == 1) {
			var el = node.childNodes[i-12];
			var img = el.getElementsByTagName('img');
			img[0].style.marginTop = mTop;
			points--;
		}
	}
	updatePoints();
}

/*
	Returns the "number" of the skill's tree selected
	@el 	: 	HTML node of the SELECT
*/
function countSkillTree(el) {
	var select = el.childNodes[0];
	var i=0;
	var bool = false;
	while (i<select.childNodes.length && !bool) {
		if (select.childNodes[i].selected) {
			bool = true;
		}
		i++;
	}
	if (bool = false) {
		return 0;
	} else {
		// -2 because we iterate i one more every time 
		// and because of the text element in the select
		return i-2;
	}
}

/*
	Create the parameter's string
	@el 	: 	HTML node of the skill tree selected
	@nb 	: 	Number of the childnode's (0 active / 1 passive)
*/
function createParameterString(el, nb) {
	var node = el.childNodes[nb];
	var s = '';
	for (var i=0; i<node.childNodes.length; i++) {
		if (node.childNodes[i].getElementsByTagName('img')[0].style.marginTop == mTop) {
			s += '1';
		} else {
			s += '0';
		}
	}
	return s;
}

/*
	Return the string parameter of the skills selected within the tree
	@el 	: 	HTML node of the skill tree selected
*/
function countSkills(el) {
	var aStr = createParameterString(el, 0); // Active skills
	var pStr = createParameterString(el, 1); // Passive skills
	return aStr + pStr;
}

/*
	Create the link to "save" the build
*/
function createLink() {
	var dom = document.getElementById('tal_box');
	var urlParam = '';

	// Create the 3 block of the parameter
	for (var i=0; i<3; i++) {
		var tree = dom.childNodes[1+i];
		var nbTree = countSkillTree(tree.childNodes[0]);
		var skillString = countSkills(tree.childNodes[nbTree+2]);
		if (i<2) {
			urlParam += nbTree.toString() + skillString + 'x';
		} else {
			urlParam += nbTree.toString() + skillString;
		}
		
	}

	// Display the link
	var url = window.location.protocol + '//' +
		window.location.host + 
		window.location.pathname +
		'?talCode=' + urlParam;
	document.getElementById('tal_buildLink').innerHTML = '<a href="' + url + '">' +
		url + '</a>';
}

/*
	Display particular build link if there is an URL parameter (talCode)
*/
window.onload = function () {
	if (document.URL.indexOf('talCode=') > 0) {
		var tab = document.URL.split('=')[1].split('x');
		var dom = document.getElementById('tal_box');

		for (var i=0; i<tab.length; i++) {
			// Display a particular tree
			var t = tab[i].split('');
			var tree = dom.childNodes[1+i];
			var el = tree.childNodes[parseInt(t[0])+2];
			el.style.display = 'inline';

			// Lock and display the select accordingly
			tree.childNodes[0].childNodes[0].childNodes[parseInt(t[0])+1].selected = true;
			lock(tree.childNodes[0].childNodes[0].childNodes[parseInt(t[0])+1].value);
			
			// Highlight the particular skills in that tree
			var nodeA = el.childNodes[0]; // Active skills
			var nodeP = el.childNodes[1]; // Passive skills
			highlightActiveSkills(t, nodeA);
			highlightPassiveSkills(t, nodeP);
		}
	}
}