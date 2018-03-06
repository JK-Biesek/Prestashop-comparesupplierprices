{*
* 2007-2014 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2014 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
				<div class="panel" id="benefits">
					<div class="panel-heading">
						<i class="icon-money"></i>
				</div>
					<br/><br/>
				<div class="clearfix">
				</div>
				<br/>
						<!-- counting the elements of sup_prod_details array -->
						{foreach from=$sup_prod_details key=id item=details}
								{assign var="count" value=0}
								{foreach from=$details item=detail}
										{assign var="count" value=$count + ($detail.quantity|@count)}
								{/foreach}
								Total elementos <b>{$details.0.supplier_name|upper}</b>: Total <b>{$count}</b><br/>
						{/foreach}
							<br/>
							{if $supplier_price_to_compare}
						  <table class="table">
							<caption><h3>Compare products prices</h3></caption>
							<thead>
			            <tr>
			                <th><h4>Products </h4></th>
											<th><h4>ID</h4></th>
			                <th><h4>Supplier</h4></th>
											<th><h4>Supplier Ref</h4></th>
			                <th><h4>Supplier Price</h4></th>
			            </tr>
			        </thead>
							<tbody>
							<!-- array with prod_id and its id attr along with price,supplier name and its reference -->
							{foreach from=$supplier_price_to_compare key=k item=id_con_attr}
								{foreach from=$id_con_attr key=ref item=item}
								{assign 'myArray' [$item.id_supplier => $item.product_supplier_price_te]}
								<tr>
								<td>{$item.product}</td>
								<td>{$item.id_product}</td>
								<td><b>{$item.name}</b></td>
								<td>{$item.product_supplier_reference|upper}</td>
								<td><b>{convertPrice price = $item.product_supplier_price_te}</td></b>
								</tr>
								{/foreach}
							{/foreach}
							<!-- array with suppliers names and ids as key -->
							{foreach from=$supplier_name key=id item=supplier_brand}
								<tfoot>
										<tr>
												<th><strong style="color:#0684ff">Total {$supplier_brand}</strong> con total de <b>{$count.$id}</b> productos</th>
												<th><strong>--</strong></th>
												<th><strong>--</strong></th>
												<th><strong>--</strong></th>
												<!-- supplier_totals is an array with total of prices from supplier prices of products -->
												<th><strong style="color:#0684ff">{convertPrice price = $supplier_totals.$id}</strong></th>
										</tr>
								</tfoot>
								{/foreach}
							</tbody>
  				</table>
					{/if}
          <br/>
</div>
