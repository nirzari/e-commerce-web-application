<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors','On');

if(!isset($_SESSION['id'])) 
	$_SESSION['id']= array();
if(!isset($_SESSION['image']))
	$_SESSION['image'] = array();
if(!isset($_SESSION['name']))
	$_SESSION['name'] = array();
if(!isset($_SESSION['price']))
	$_SESSION['price'] = array();
if(!isset($_SESSION['desc']))
	$_SESSION['desc'] = array();

if(!isset($_SESSION['baskid'])) 
	$_SESSION['baskid']= array();
if(!isset($_SESSION['baskimage']))
	$_SESSION['baskimage'] = array();
if(!isset($_SESSION['baskname']))
	$_SESSION['baskname'] = array();
if(!isset($_SESSION['baskprice']))
	$_SESSION['baskprice'] = array();
if(!isset($_SESSION['baskdesc']))
	$_SESSION['baskdesc'] = array();
if(!isset($_SESSION['bascount']))
	$_SESSION['bascount'] = 0;
if(!isset($_SESSION['TotalPrice']))
	$_SESSION['TotalPrice'] = 0;
if(isset($_GET['clear'])){
	unset($_SESSION['baskid']);
	unset($_SESSION['baskimage']);
	unset($_SESSION['baskname']);
	unset($_SESSION['baskprice']);
	unset($_SESSION['baskdesc']);
	$_SESSION['bascount'] = 0;
	$_SESSION['TotalPrice'] = 0;
}
?>

<html>
<head><title>Buy Products</title></head>
<body>
<?php
if(isset($_GET['buy'])){
	
		for($i = 0; $i<count($_SESSION['id']);$i++)
		{
			if(($_SESSION['id'][$i])==$_GET['buy'])
			{
				$_SESSION['baskid'][$_SESSION['bascount']] = $_SESSION['id'][$i];
				$_SESSION['baskname'][$_SESSION['bascount']] = $_SESSION['name'][$i];
				$_SESSION['baskprice'][$_SESSION['bascount']] = $_SESSION['name'][$i];
				$_SESSION['baskimage'][$_SESSION['bascount']]= $_SESSION['image'][$i];
				$_SESSION['baskprice'][$_SESSION['bascount']] = $_SESSION['price'][$i];
				$_SESSION['TotalPrice'] += $_SESSION['price'][$i];
				$_SESSION['bascount']++;
			}
		}
}

if(isset($_GET['delete'])){
	$j = 0;
	$_SESSION['TotalPrice'] = 0 ;
	for($i = 0; $i<$_SESSION['bascount'];$i++){
		if($_SESSION['baskid'][$i] != $_GET['delete']){
			$_SESSION['baskname'][$j] = $_SESSION['baskname'][$i];
			$_SESSION['baskprice'][$j] = $_SESSION['baskprice'][$i];
			$_SESSION['baskimage'][$j] = $_SESSION['baskimage'][$i];
			$_SESSION['TotalPrice'] += $_SESSION['baskprice'][$i];
			$j++;
		}
	}
	$_SESSION['bascount'] = $_SESSION['bascount']-1;
}

echo "<p>Shopping Basket:</p>";
echo "<p> Total Items:".$_SESSION['bascount']."</p>";
echo "<table border=1>";
for($i = 0; $i<$_SESSION['bascount'];$i++){
			echo "<tr><td><img src =" .$_SESSION['baskimage'][$i]. "</img></td>";
			echo "<td>" .$_SESSION['baskname'][$i]. "</td>";
			echo "<td>" .$_SESSION['baskprice'][$i]. "</td>";
			echo "<td><a href = buy.php?delete=".$_SESSION['baskid'][$i]."> delete </td></tr>";	
}
echo "</table>";
echo "<p/>";
$TotalPrice =  $_SESSION['TotalPrice'];

echo "Total: ".$TotalPrice. "$<p/>";
echo "<form action='buy.php' method='GET'>";
echo "<input type='hidden' name='clear' value='1'/>";
echo "<input type='submit' value='Empty Basket'/>";
echo "</form>";

$catxmlstr = file_get_contents('http://sandbox.api.ebaycommercenetwork.com/publisher/3.0/rest/CategoryTree?apiKey=78b0db8a-0ee1-4939-a2f9-d3cd95ec0fcc&visitorUserAgent&visitorIPAddress&trackingId=7000610&categoryId=72&showAllDescendants=true');
$catxml = new SimpleXMLElement($catxmlstr);
echo "<form action='buy.php' method='GET'>";
echo "<fieldset><legend>Find products:</legend>";
echo "<label>Category: ";
echo "<select name=id>"; 
foreach($catxml->category as $cat){
	echo "<optgroup label='".$cat->name.":'>";
	echo "<option value=" .$cat['id']. "> " .$cat->name. "</option>";
	foreach($cat->categories->category as $cats){
		echo "<optgroup label='".$cats->name.":'>";
		echo "<option value=" .$cats['id']. ">" .$cats->name. "</option>";
		foreach($cats->categories->category as $inCats){
			echo "<option value=" .$inCats['id']. ">" .$inCats->name. "</option>";
		}
	}
}
	echo "</select>";
	echo "</label>"; 
	echo "<label> Search Keywords: <input type='text' name='keyword'/></label>";
	echo "<input type='submit' value='search'/>";
	echo "</fieldset>";
	echo "</form>";
	
if(isset($_GET['keyword']) && isset($_GET['id'])){
	$id = $_GET['id'];
	$key = $_GET['keyword'];	
	$keyxmlstr = file_get_contents('http://sandbox.api.ebaycommercenetwork.com/publisher/3.0/rest/GeneralSearch?apiKey=78b0db8a-0ee1-4939-a2f9-d3cd95ec0fcc&trackingId=7000610&category=' .urldecode($id).'&keyword='.urlencode($key).'&numItems=20');		
	$keyxml = new SimpleXMLElement($keyxmlstr);
	
	foreach ($keyxml->categories->category as $c)
	{
		$loop = 0;
		foreach($c->items->product as $i)
		{
			$_SESSION['id'][$loop] = (string)$i['id'];
			$_SESSION['image'][$loop] = (string)$i->images->image->sourceURL;
			$_SESSION['name'][$loop] = (string)$i->name;
			$_SESSION['price'][$loop] = (string)$i->minPrice;
			$_SESSION['desc'][$loop] = (string)$i->fullDescription;
			$loop = $loop + 1;
		}
	}
}	
	echo "<table border='2'>";
	for($i = 0; $i<count($_SESSION['id']);$i++){
			echo "<tr><td><a href=buy.php?buy=".$_SESSION['id'][$i]."><img src =" .$_SESSION['image'][$i]. "</img></td>";
			echo "<td>" .$_SESSION['name'][$i]. "</td>";
			echo "<td>"  .$_SESSION['price'][$i]. "</td>";
			echo "<td>" .$_SESSION['desc'][$i]. "</td></tr>";
	}
	echo "</table>";
	
?>
</body>
</html>
