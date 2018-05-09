<?php
if (!(defined('WHMCS'))) 
{
	exit('This file cannot be accessed directly');
}
add_hook('ClientAreaPrimaryNavbar', 1, function(\WHMCS\View\Menu\Item $primaryNavbar) 
{
	if (!(is_null($primaryNavbar->getChild('Services')))) 
	{
		$primaryNavbar->getChild('Services')->addChild('UnlimitedGeninvoices')->setLabel('提前续费')->setUri('index.php?m=UnlimitedGeninvoices')->setOrder(10);
	}
}
);