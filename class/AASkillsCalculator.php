<?php

/*
	Archeage Skill Calculator
	2014/05/17
*/

class AASkillsCalculator {
	
	var $_xml;	// Contenu xml

	function AASkillsCalculator ($xml="xml/aa_skillsLists.xml") {
		// Chargement du XML
		$this->_xml = new DomDocument();
		$this->_xml->load($xml);
	}

	/*
		Return the calculator's HTML
	*/
	function getTree() {
		// Affichage de la page
		$html = '<div id="tal_box">';
		$html .= '<p>You can still use <span id="skillPoints">23</span> points.</p>';
		$html .= '<div class="tal_tree">';
		$html .= $this->createTree();
		$html .= '</div>';
		$html .= '<div class="tal_tree">';
		$html .= $this->createTree();
		$html .= '</div>';
		$html .= '<div class="tal_tree">';
		$html .= $this->createTree();
		$html .= '</div>';
		$html .= '<div id="tal_linkBox">';
		$html .= '<button onClick="createLink()">Create a link</button>';
		$html .= '<p id="tal_buildLink"></p>';
		$html .= '</div>';
		return $html;
	}

	/*
		Return one tree's HTML
	*/
	function createTree() {
		$tree = $this->_xml->getElementsByTagName('ecole');
		$html = $this->getSpec($tree);
		$html .= '<div class="tal_clear"></div>';
		$html .= $this->getSkills($tree);

		return $html;
	}


	/*
		Return the skills's HTML from one tree
		@tree 	: 	Tree's XML node (ecole)
	*/
	function getSkills($node) {
		$html ='';
		foreach ($node as $branch) {
			$html .= '<div id="'.$branch->getAttribute('id').'" class="tal_invisible">';
			$html .= $this->getActive($branch);
			$html .= $this->getPassive($branch);
			$html .= '</div>';
		}

		return $html;
	}

	/*
		Return the list of the skill trees
		@node 	:	 Tree's XML node (ecole)
	*/
	function getSpec($node) {
		$html = '<div id="tal_ecoles">';
		$html .= '<select id="tal_listEcoles" onchange="tal_display(this)">';
		$html .= '<option value="0" selected="" disabled="">Choose...</option>';
		foreach ($node as $branch) {
			$html .= '<option value="'.$branch->getAttribute('id').'">'.$branch->getAttribute('name').'</option>';
		}
		$html .= '</select>';
		$html .= '</div>';

		return $html;
	}

	/*
		Return the active skills from one tree
		@node 	:	Active's XML node (ecole > active)
	*/
	function getActive($node) {
		$active = $node->getElementsByTagName('active');
		foreach ($active as $a) {
			$skill = $a->getElementsByTagName('skill');
			$html = '<div class="tal_activeSkills">';
			foreach ($skill as $s) {
				$html .= '<li onClick="toggleSkill(this)">
					<img src="'.$s->getAttribute('img').'" onMouseOver="displayStats(this)" onMouseOut="hideStats(this)" />';
				$html .= '<div class="tal_stats">'.$this->getSkillDetail($s).'</div>';
				$html .= '</li>';
			}
			$html .= '</div>';
		}

		return $html;
	}

	/*
		Return the active skills from one tree
		@node 	:	Passive's XML node (ecole > passive)
	*/
	function getPassive($node) {
		$active = $node->getElementsByTagName('passive');
		foreach ($active as $a) {
			$skill = $a->getElementsByTagName('skill');
			$html ='<div class="tal_passiveSkills">';
			foreach ($skill as $s) {
				$html .= '<li class="tal_passive" data-req="'.$s->getAttribute('req').'" onClick="toggleSkill(this)">
					<img src="'.$s->getAttribute('img').'" onMouseOver="displayStats(this)" onMouseOut="hideStats(this)" />';
				$html .= '<div class="tal_stats">'.$this->getSkillDetail($s).'</div>';
				$html .= '</li>';
			}
			$html .= '</div>';
		}

		return $html;
	}

	/*
		Get the skill details (mana, cooldown, etc)
		@node 	:	Skill's XML node (ecole > passive/active > skill)
	*/
	function getSkillDetail($node) {
		$html = '<h3>'.$node->getAttribute('name').'</h2>';
		$stat = $node->getElementsByTagName('stat');
		$desc = $node->getElementsByTagName('description');
		foreach ($desc as $d) {
			$html .= '<p>'.utf8_decode($this->renderTags($d->nodeValue)).'</p>';
		}
		$html .= '<div class="statBox">';
		foreach ($stat as $s) {
			$html .= '<p class="statLine"><span class="tal_sTitle">'.ucfirst(utf8_decode($s->getAttribute('name'))).'</span>: '.utf8_decode($s->nodeValue).'</p>';
		}
		$html .= '</div>';


		return $html;
	}

	/*
		Transform custom tag into HTML tag
		@str 	: 	String
		@Custom tag
			--b-- / ++b++ 	=> 	<b> / </b>
	*/
	function renderTags($str) {
		return str_replace(array('--b--', '++b++'), array('<b>', '</b>'), $str);
	}
}


?>