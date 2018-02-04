	/*jshint esversion: 6 */

	//init function will return tools listing in table format from url ( toolList.php )
function initSearchUpdate(url, phpFile){
		let toolSearch = document.getElementById('tool_search');
		let tableBody = document.getElementById('search_table_body');
		let update = document.getElementsByClassName('update_data');
		let update_display = document.getElementById('update_display');
		let show_sold = document.getElementById('show_sold');
		let toggle = false;
	

		/**
		 * toolData is the tools listings retrieved from url supplied
		 * returns promise with response.json()
		 **/
		let toolData = fetch(url).then( 
			function(response){
				if(response.ok){
					return response.json();
				}
				return 'Error fetching toolData';
			}
		);

		//check tools array against e.target.value ( user submitted search )
		function initToolSearch(e){
			//get toggle for sold or unsold listings
			let toggleNum = 1;
			if(toggle === false){
				toggleNum = - 1;
			}else{
				toggleNum = 1;
			}
			let searchVal = toolSearch.value.toLowerCase() || '';
			tableBody.innerHTML = '';

			//display table data of filtered tools. with event listeners for each element
			toolData.then( (tools)=>{
			tools.filter( (tool)=>{
				//String of all the tool categories to search through for a match
				let name  = tool.name.toLowerCase();
				let info = tool.description.toLowerCase();
				let brand = tool.brand.toLowerCase();
				let toolid = tool.id;
				let tool_condition = tool.tool_condition.toLowerCase();
				let toolsInfo = name + ' ' + info  + ' ' + brand + ' ' +  tool_condition + ' ' + toolid;
				if(searchVal !== ""){
					return toolsInfo.match(searchVal);
				}
				console.log('no input text');
				return tool;
				
			}).filter((tools)=>{
				//return only not sold tools
				return tools.sold == toggleNum;
			}).map( (tool) => {
				if(tool.max_price === '0'){
					toolMaxPrice = '';
				}else{
					toolMaxPrice = ' - ' + tool.max_price;
				}
				tableBody.innerHTML += `
										<tr val="${tool.id}" name="${tool.name}">
										<td class="update_data"> ${tool.name} </td>
										<td class="update_data"> ${tool.brand} </td>
										<td class="update_data"> ${tool.type} </td>
										<td class="update_data"> ${tool.description} </td>
										<td class="update_data"> ${tool.tool_condition} </td>
										<td class="update_data"> ${tool.price} ${toolMaxPrice}</td>
										<td class="update_data"> ${tool.id} </td>
										</tr>
								`;
			});
		}).then(
			function(){
				for (var i = update.length - 1; i >= 0; i--) {
					update[i].parentElement.addEventListener('dblclick', dblClickHandleUpdate);
					//update[i].parentElement.addEventListener('click', handleUpdate);
				}
			}
		);
	}

	//default first view table of tools ( only shows not sold tools )
	function firstLoad(){
		toolData.then( ( tools ) => {
			tools.filter((tools)=>{
				//return only not sold tools
				return tools.sold == -1;
			}).map( (tool) => {
				if(tool.max_price === '0'){
					toolMaxPrice = '';
				}else{
					toolMaxPrice = ' - ' + tool.max_price;
				}
				tableBody.innerHTML += `
										<tr val="${tool.id}" name="${tool.name}">
										<td class="update_data"> ${tool.name} </td>
										<td class="update_data"> ${tool.brand} </td>
										<td class="update_data"> ${tool.type} </td>
										<td class="update_data"> ${tool.description} </td>
										<td class="update_data"> ${tool.tool_condition} </td>
										<td class="update_data"> ${tool.price} ${toolMaxPrice}</td>
										<td class="update_data"> ${tool.id} </td>
										</tr>
								`;
			});
		}).then(
		//add event listener to each td element asynchronously
			function(){
				for (var i = update.length - 1; i >= 0; i--) {
					//update[i].parentElement.addEventListener('click', handleUpdate);
					update[i].parentElement.addEventListener('dblclick', dblClickHandleUpdate);
				}
			}
		);
		
	}


	window.addEventListener('load', firstLoad);
	window.addEventListener('keyup', initToolSearch);
	show_sold.addEventListener('click', toggleSoldTools);
	

		function toggleSoldTools(){

			tableBody.innerHTML = '';
			let toggleNum = 1;
			if(toggle === false){
				toggle = true;
				toggleNum = 1;
			}else{
				toggle = false;
				toggleNum = -1;
			}
			initToolSearch();

		}

		//On double click of element, submit form to update.php
		function dblClickHandleUpdate(e){
			let toolID = e.target.parentElement.getAttribute('val');
			let toolName = e.target.parentElement.getAttribute('name');
			let dblclickformcontainer = document.getElementById('dblclickformcontainer');

			if(phpFile == 'delete.php'){
				let deleteString = `Are you sure you wish to delete ${toolName} with ID of ${toolID}`;
				let confimer = confirm(deleteString);
				if(!confimer){
					message='nogo';
					return;
				}
			}

			dblclickformcontainer.innerHTML = `
			<form method=POST action='${phpFile}' id="dblclickform">
					<input type="hidden" name="tool_id" value="${toolID}" />
			</form>`;
			document.getElementById('dblclickform').submit();
		}
}


