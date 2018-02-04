	/*jshint esversion: 6 */


function Validator(){
}
Validator.prototype.validate = function(stringToValidate) {
	// check string against a regex to help ensure it isnt malicous
};
/**
 *  initSearch()
 *	@param url string
 *  @param phpFile string
 *  used on multiple pages to returnand filter our tool data in specific ways
 */
function initSearch(url, phpFile=''){

	let toolSearch = document.getElementById('tool_search');
	let tableBody = document.getElementById('search_table_body');
	let update = document.getElementsByClassName('update_data') || "";
	let update_display = document.getElementById('update_display') || "";
	let show_sold = document.getElementById('show_sold') || "";
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
	/**
	 * handleMaxPrice()
	 * if price empty return nothing, else return price with  - preceeding.
	 * @param price int
	 **/
	function handleMaxPrice(price){
		if(price === '0'){
				return ' ';
		}
		return ' - ' + price;
	}
	/**
	 * filterSearch()
	 *	@param tool object
	 *	@param searchVal string
	 *  returns searchVal and tool.matches found inside tool search
	 **/
	function filterSearch(tool, searchVal){
		//String of all the tool categories to search through for a match
			let name  = tool.name.toLowerCase();
			let info = tool.description.toLowerCase();
			let tool_condition = tool.tool_condition.toLowerCase();
			let brand = tool.brand.toLowerCase();
			let toolid = tool.id;
			let toolsInfo = name + ' ' + info  + ' ' + brand + ' ' +  tool_condition + ' ' + toolid;
			return toolsInfo.match(searchVal);
	}
	/**
	 * returnHTMLTable()
	 * @param item object
	 * @param toolMaxPrice string from handleMaxPrice()
	 * returns the finished table data
	 **/
	function returnHTMLTable(item, toolMaxPrice){
		return `<tr val="${item.id}" name="${item.name}">	
									<td class="update_data"> ${item.name} </td>
									<td class="update_data"> ${item.brand} </td>
									<td class="update_data"> ${item.type} </td>
									<td class="update_data"> ${item.description} </td>
									<td class="update_data"> ${item.tool_condition} </td>
									<td class="update_data"> ${item.price} ${toolMaxPrice} </td>
									<td class="update_data"> ${item.id} </td>
								</tr>
							`;
	}
	/**
	 * sortedBy()
	 * 	used to toggle price range
	 *	@param tools object
	 *  @param prop string ( object property )
	 *  @param range string ( high, low)
	 **/
	function sortedBy(tools, prop, range){
		let numb = -1;
		let numb2 = 1;
		if(range === 'low'){
			numb = -1;
			numb2 = 1;
		}
		if(range === 'high'){
			numb = 1;
			numb2 = -1;
		}
			return tools.sort( (prev, next) => {
				let prevPrice = '' + prev[prop];
				prevPrice = parseInt(prevPrice);
				let nextPrice = '' + next[prop];
				nextPrice = parseInt(nextPrice);
		
				if(prevPrice < nextPrice){
						return  numb; //-1
					}
					if(prevPrice > nextPrice){
						return numb2;//1
					}
				return 0;
			});
	}
	/**
	 *	toggleSoldTools
	 *
	 *
	 **/
	function toggleSoldTools(){
		tableBody.innerHTML = '';
		if(toggle){
			toggle = false;
			toggleNum = -1;
		}else{
			toggle = true;
			toggleNum = 1;
		}
		initToolSearch();
	}
	///On double click of element, submit form to update.php
	function dblClickHandleUpdate(e){
		console.log(e);
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
		//Sends id for update and submit
		dblclickformcontainer.innerHTML = `
			<form method=POST action='${phpFile}' id="dblclickform">
					<input type="hidden" name="tool_id" value="${toolID}" />
			</form>`;
		document.getElementById('dblclickform').submit();
	}

	let longTouchTimer;
	let longTouchDuration = 500;
	function longTouchStart(e){
		//e.preventDefault();
		
		longTouchTimer = setTimeout(dblClickHandleUpdate.bind(this, e), longTouchDuration);
	}
	function longTouchEnd (e){
		//e.preventDefault();
		if(longTouchTimer){
			clearTimeout(longTouchTimer);
		}
	}
	//
	function sortThem(tools, sortBy=''){
		if(sortBy === "price"){
			if(toggled){
				toggled = false;
				tools = sortedBy(tools, 'price', 'low');
			}else{
				toggled = true;
				tools = sortedBy(tools, 'price', 'high');
			}
		}
	}
	/**
	 * initToolSearch()
	 * e - event listener
	 *
	 **/
	//check tools array against e.target.value ( user submitted search )
	let toggled = true;
	let toggleNum = -1;
	function initToolSearch(e, sortBy=''){
			phpFile = phpFile.trim();
			let searchVal = tool_search.value;
			tableBody.innerHTML = '';

			//display table data of filtered tools. with event listeners for each element
			toolData.then( (tools)=>{
				//sorts based on sortBy Param
				sortThem(tools, sortBy);
				//put this into function eventually 
				tools.filter( (tool)=>{
					return filterSearch(tool, searchVal);
				}).filter( (tool) => {
					//return only not sold tools, if is update show sold or only show not sold
					if(phpFile=="update.php" || phpFile=="delete.php"){return tool.sold == toggleNum;}
					return tool.sold == -1;
				}).map( (tool) => {
					let toolMaxPrice = handleMaxPrice(tool.max_price);
					tableBody.innerHTML += returnHTMLTable(tool, toolMaxPrice);
					//return tool;
				});
		}).then(function(){
				if(phpFile=="update.php" || phpFile=="delete.php" || phpFile=="single-tool-view/index.php"){
					for (var i = update.length - 1; i >= 0; i--) {
						//update[i].parentElement.addEventListener('click', handleUpdate);
						update[i].parentElement.addEventListener('dblclick', dblClickHandleUpdate);
						update[i].parentElement.addEventListener('touchstart', longTouchStart);
						update[i].parentElement.addEventListener('touchend', longTouchEnd );
					}
				}
			});
	}

	/**
	 * Event Listeners
	 *
	 *
	 **/
	window.addEventListener('load', initToolSearch);
	window.addEventListener('keyup', initToolSearch);
	if(show_sold !== null && show_sold !== "" && show_sold){
		show_sold.addEventListener('click', toggleSoldTools);
	}
    let price_filter = document.getElementById('price_filter');

	price_filter.addEventListener('dblclick', function(e){
			initToolSearch(e, "price");
	}, false); 

   var onlongtouch = function(e){
		initToolSearch(e, "price");
	};
	var timer;
	var touchduration = 500; //length of time we want the user to touch before we do something
	price_filter.addEventListener('touchstart', function(e){
			e.preventDefault();
			timer = setTimeout(onlongtouch, touchduration); 
	});
	price_filter.addEventListener('touchend', function(e){
			e.preventDefault();
			 if(timer){
			 	clearTimeout(timer);
			 } 
	});
	
}



		



		

	
	

