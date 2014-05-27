<?php

/*
	Archeage Skill Calculator
	2014/05/17
*/

class AASkillsCalculator {
	
	private $_xml;	// XML content

	public function AASkillsCalculator ($xml="xml/aa_skillsLists.xml") {
		// Load XML
		if (file_exists($xml)) {
			$this->_xml = simplexml_load_file($xml);
		} else {
			exit('Error while loading XML file.');
		}
	}

	/*
		Return the calculator's HTML
	*/
	public function getTree() {
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
	private function createTree() {
		$html = $this->getSpec();
		$html .= '<div class="tal_clear"></div>';
		$html .= $this->getSkills();

		return $html;
	}


	/*
		Return the skills's HTML from one tree
	*/
	private function getSkills() {
		$html ='';
		foreach ($this->_xml->ecole as $branch) {
			$html .= '<div id="'.$branch['id'].'" class="tal_invisible">';
			$html .= $this->getActive($branch);
			$html .= $this->getPassive($branch);
			$html .= '</div>';
		}

		return $html;
	}

	/*
		Return the list of the skill trees
	*/
	private function getSpec() {
		$html = '<div id="tal_ecoles">';
		$html .= '<select id="tal_listEcoles" onchange="tal_display(this)">';
		$html .= '<option value="0" selected="" disabled="">Choose...</option>';
		foreach ($this->_xml->ecole as $branch) {
			$html .= '<option value="'.$branch['id'].'">'.$branch['name'].'</option>';
		}
		$html .= '</select>';
		$html .= '</div>';

		return $html;
	}

	/*
		Return the active skills from one tree
		@node 	:	Tree's XML node (ecole)
	*/
	private function getActive($node) {
		$html = '<div class="tal_activeSkills">';
		foreach ($node->active->skill as $s) {
			$html .= '<li onClick="toggleSkill(this)">
				<img src="'.$s['img'].'" onMouseOver="displayStats(this)" onMouseOut="hideStats(this)" />';
			$html .= '<div class="tal_stats">'.$this->getSkillDetail($s).'</div>';
			$html .= '</li>';
		}
		$html .= '</div>';

		return $html;
	}

	/*
		Return the active skills from one tree
		@node 	:	Tree's XML node (ecole)
	*/
	private function getPassive($node) {
		$html ='<div class="tal_passiveSkills">';
		foreach ($node->passive->skill as $s) {
			$html .= '<li class="tal_passive" data-req="'.$s['req'].'" onClick="toggleSkill(this)">
				<img src="'.$s['img'].'" onMouseOver="displayStats(this)" onMouseOut="hideStats(this)" />';
			$html .= '<div class="tal_stats">'.$this->getSkillDetail($s).'</div>';
			$html .= '</li>';
		}
		$html .= '</div>';

		return $html;
	}

	/*
		Get the skill details (mana, cooldown, etc)
		@node 	:	Skill's XML node (ecole > passive/active > skill)
	*/
	private function getSkillDetail($node) {
		$html = '<h3>'.$node['name'].'</h2>';
		$html .= '<p>'.utf8_decode($this->renderTags($node->description)).'</p>';
		$html .= '<div class="statBox">';
		foreach ($node->stat as $s) {
			$html .= '<p class="statLine"><span class="tal_sTitle">'.ucfirst(utf8_decode($s['name'])).'</span>: '.utf8_decode($s).'</p>';
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
	private function renderTags($str) {
		return str_replace(array('--b--', '++b++'), array('<b>', '</b>'), $str);
	}
}


?>