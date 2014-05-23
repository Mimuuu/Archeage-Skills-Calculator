Archeage-Skills-Calculator
==========================

A pure php/javascript skill calculator for the game Archeage. Very easy to implement and to use.
A basic webpage is set up at http://s285114191.onlinehome.fr/AASkillsCalculator/.

The PHP file is used to create the basic setup, the 3 lists, the button and the hidden content. The JS file takes care of every interaction, create the link and also read the - if existed - parameter and display the page accordingly.

Nothing but pure PHP / JS was used in order to use it the easiest way possible, without having to deal with any framework.

##### What's missing #####
The XML file is currently filled with false content. The same image and description is used for everything. The XML format is described further.

## How the files work ##
#### PHP file ####
Read the XML and return the HTML code of the calculator.
#### JS file ####
Everything is in one file so it's easier to implement, however the code inside the file is divided into several parts so it's still easy to read and edit:
* **Lists related** - Functions related to the "select" lists.
* **Skills related** - Functions related to anything that touches specific skills (highlight selected skills, display details, ...).
* **Points related** - Functions related to the points count.
* **URL/Skills related** - Functions related to the creation of the link, and reading the parameter to display a specific build.

It is also worth mentioning that the **parentNode** / **childNodes** combination has been abused a lot, so changing casually the HTML would most likely break the entire thing.

## Implement the calculator ##
It's very easy, all you need to do is include the PHP file, the JS file and the CSS file.
```php
require_once 'class/AASkillsCalculator.php';

<link rel="stylesheet" type="text/css" href="css/style_aaSkillsCalculator.css">
<script type="text/javascript" src="js/aa_skillsCalculator.js"></script>
```
Then you call the **getTree()** method to generate the 3 lists and everything, afterwards the JS file takes care of everything.
```php
echo $AASkillsCalculator->getTree();
```
