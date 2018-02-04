
<h2 class="search_text">Search and choose tool to begin updating.</h2>
<input type="text" id="tool_search" >

<br>
<input type="checkbox" id="show_sold">
<label for="show_sold"><p class="toggle_description">Click to Toggle Sold Tools</p></label>
<p class="description">Only shows not sold tools unless the checkbox is checked</p>

<p class="description">Double click, or hold down ( if using phone ) on a table listing to update that tool.</p>
<p class="description">Double click, or hold down ( if using phone ) on price to filter by price.</p>
<table border="1" class="table_of_tools">

	<thead>
		<tr>
			<th>Tool</th>
			<th>Brand</th>
			<th>Type</th>
			<th>Description</th>
			<th>Condition</th>
			<th id="price_filter">Price</th>
			<th>ID</th>
		</tr>
	</thead>
	<tbody id="search_table_body">
	</tbody>
</table>

<div id="dblclickformcontainer">
	<!--form from tool-update.js here-->
</div>

<div id="update_display" class="update_display"></div>
