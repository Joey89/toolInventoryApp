	/*jshint esversion: 6 */
class ErrorHandleFlash{
	constructor(){
		this.tool_message_flash_remove = document.getElementById('tool_message_flash_remove');
		this.tool_container = document.getElementById('tool_container');
		//create event listner
	}
	init(){
		if(this.tool_container){
			this.tool_message_flash_remove.addEventListener('click', messageHandler.hideMessage.bind(this, this.tool_container));
		}
	}
	
	hideMessage(ele){
		if(ele !== ''){
			ele.style.display = 'none';
			return true;
		}
		return false;
	}
}
// ErrorHandleFlash.prototype.tool_container = function(){
// 	tool_container = document.getElementById('tool_container');
// };
	let messageHandler = new ErrorHandleFlash();
	messageHandler.init();
 