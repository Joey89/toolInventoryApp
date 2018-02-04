	/*jshint esversion: 6 */
		let newToolCheckBox = document.getElementById('new_tool');
		let toolOption = document.getElementById('tool_option');
		let tool_from_scratch = document.getElementById('tool_from_scratch');
		let brand_tool_checkbox = document.getElementById('brand_tool');
		let brand_from_scratch = document.getElementById( 'brand_from_scratch');
		let price_max_checkbox = document.getElementById('price_range_max');
		let max_price_range = document.getElementById('max_price_range');


		function ToolCreator(){
			this.toggler = true;
			this.checkBoxToggler = true;
		}
		ToolCreator.prototype.toggleDisabled = function(ele, cb){
			if(this.checkBoxToggler){
				ele.disabled = false;
				this.checkBoxToggler = false;
			}else{
				ele.disabled = true;
				this.checkBoxToggler = true;
			}
			cb(this.checkBoxToggler);
		};
		ToolCreator.prototype.toggle = function(ele, cb){
			if(this.toggler){
				ele.style.display = 'none';
				this.toggler = false;
			}else{
				ele.style.display = 'block';
				this.toggler = true;
			}
			cb(this.toggler);
		};

		let toolCreator = new ToolCreator();
		let brandCreator = new ToolCreator();
		let priceToggler = new ToolCreator();

		window.addEventListener('load', function(){

		if(newToolCheckBox){
			newToolCheckBox.addEventListener('click', function(e){
				toolCreator.toggle(toolOption, function(toggler){
					if(!toggler){
						tool_from_scratch.innerHTML = `<input type="text" name="tool_option_new" placeholder="Add New Tool Here">`;
					}else{
						tool_from_scratch.innerHTML = '';
					}

				});
			});
		}

		if(brand_tool_checkbox){
			brand_tool_checkbox.addEventListener('click', function(e){
				brandCreator.toggle(brand_option, function(toggler){
					if(!toggler){
						brand_from_scratch.innerHTML = `<input type="text" name="brand_option_new" placeholder="Add New Brand Here">`;
					}else{
						brand_from_scratch.innerHTML = '';
					}
				});
			});
		}

		if(price_max_checkbox){
			price_max_checkbox.addEventListener('click', function(e){
				priceToggler.toggleDisabled(max_price_range, function(toggler){});
			});
		}

		}, true);