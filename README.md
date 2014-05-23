Archeage-Skills-Calculator
==========================

A pure php/javascript skill calculator for the game Archeage. Very easy to implement and to use.
A basic webpage is set up at http://s285114191.onlinehome.fr/AASkillsCalculator/.

The PHP file is used to create the basic setup, the 3 lists, the button and the hidden content. The JS file takes care of every interaction, create the link and also read the - if existed - parameter and display the page accordingly.

Nothing but pure PHP / JS was used because it is not a big project and so you can use it without loading / installing anything else.

###### What's missing ######
The XML file is currently filled with false content. The same image and description is used for everything. The XML format is described further.

### Implement the calculator ###
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
After this, you are good to go.
