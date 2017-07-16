<!-- CSS -->
<link rel="stylesheet" href="modules/addons/UnlimitedGeninvoices/static/css/style.css">
<link rel="stylesheet" href="modules/addons/UnlimitedGeninvoices/static/css/magic-check.css">
<style>
.table-container
{
width: 100%;
overflow-y: auto;
_overflow: auto;
margin: 0 0 1em;
}

.table-container::-webkit-scrollbar
{
-webkit-appearance: none;
width: 14px;
height: 14px;
}

.table-container::-webkit-scrollbar-thumb
{
border-radius: 8px;
border: 3px solid #fff;
background-color: rgba(0, 0, 0, .3);
}

.table-container-outer { position: relative; }

.table-container-fade
{
	position: absolute;
	right: 0;
	width: 30px;
	height: 100%;
	background-image: -webkit-linear-gradient(0deg, rgba(255,255,255,.5), #fff);
	background-image: -moz-linear-gradient(0deg, rgba(255,255,255,.5), #fff);
	background-image: -ms-linear-gradient(0deg, rgba(255,255,255,.5), #fff);
	background-image: -o-linear-gradient(0deg, rgba(255,255,255,.5), #fff);
	background-image: linear-gradient(0deg, rgba(255,255,255,.5), #fff);
}
</style>
{if ($successreturn)}
<div class="alert alert-success" role="alert">{$successreturn}</div>
{/if}
{if ($errorreturn)}
<div class="alert alert-danger" role="alert">{$errorreturn}</div>
{/if}
<div class="plugin">
	{if ($type == 1)}
		<div class="row">
			<div class="col-md-12">
				<!--widget start-->
				<aside class="profile-nav alt">
					<section class="panel">
						<header class="panel-heading">
							{$_ADDONLANG['Choose_Renew_Product']}
						</header>
						<ul class="nav nav-pills nav-stacked">
							{$productlist}
						</ul>
					</section>
				</aside>
			</div>
		</div>		
	{/if}
	{if ($type == 2)}
    <div class="row">
        <div class="col-md-12">
            <aside class="profile-nav alt">
                <section class="panel">
                    <ul class="nav nav-pills nav-stacked">
						<li><a href="javascript:;"> <i class="fa fa-spinner"></i> {$_ADDONLANG['Service_ID']}:{$product['id']} </a></li>
                        <li><a href="javascript:;"> <i class="fa fa-calendar-check-o"></i> {$_ADDONLANG['Duedate']}: {$product['duedate']} </a></li>
						<li><a href="javascript:;"> <i class="fa fa-list-alt"></i> {$_ADDONLANG['Product/Service']} : {$product['name']} </a></li>
						<li><a href="javascript:;"> <i class="fa fa-check-square-o"></i> {$_ADDONLANG['Renew_Price']} : {$product['amount']} </a></li>
					</ul>
                </section>
            </aside>
		<section class="panel">
			<header class="panel-heading">
				{$_ADDONLANG['Product_Renew']}
			</header>
			<div class="panel-body">
				<form method="post">
					{foreach $dataarray as $data}
						<div>
						  <input class="magic-radio" type="radio" name="BillingTimes" id="{$data}" value="{$data}" {if $data == 1}checked{/if}>
						  <label for="{$data}">{$data}{$_ADDONLANG['renew_times']}({$_ADDONLANG['Currency_symbol']}{$product['amount']*$data})</label>
						</div>
					{/foreach}
					<hr></hr>
					<input class="btn btn-success" type="submit" value="{$_ADDONLANG['Create_invoice']}">		
				</form>	
					<hr></hr>
					<a href="index.php?m=UnlimitedGeninvoices">
						<button class="btn btn-primary btn" >
							{$_ADDONLANG['Back_to_Main']}
						</button>
					</a>
			</div> 
		</section>		
	</div>
	{/if}	
</div>