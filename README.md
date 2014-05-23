Archeage-Skills-Calculator
==========================

A pure php/javascript skill calculator for the game Archeage. Very easy to implement and to use.
A basic webpage is set up at http://s285114191.onlinehome.fr/AASkillsCalculator/.

###### What's missing ######
The XML file is currently filled with false content. The same image and description is used for everything. The XML format is described further.

### Implement the calculator ###
It's very easy, all you need to do is include the PHP file, the JS file and the CSS file.
```php
require_once 'class/AASkillsCalculator.php';
<link rel="stylesheet" type="text/css" href="css/style_aaSkillsCalculator.css">
<script type="text/javascript" src="js/aa_skillsCalculator.js"></script>
```
Then you call the **getTree()** method.
```php
echo $AASkillsCalculator->getTree();
```
After this, you are good to go.
