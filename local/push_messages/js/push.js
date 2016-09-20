function SupportPush() {
	this.default_favicon  = '/favicon.ico';
	this.new_push_favicon = '/favicon.gif';
	
	this.default_title  = '����������� ���������';
	this.new_push_title = '����� �����������';
	
	this.unchecked_push  = 0; // ��������� ����, ���� �� ������������� �����������
	this.bitrix_panel    = $("#bx-panel");
	this.popup_container = $("#popup_container");
	
	this.popup_template = '<div style="opacity: 0" class="push_message">\
								<div class="message_header">\
									<span>\
										<%=popup_header%>\
									</span>\
									<span class="close_push_popup"><img src="/i/close_popup.png" alt="�������" /></span>\
								</div>\
								<div class="message_body">\
									<%=popup_message%>\
								</div>\
							</div>';
	
	this.pulse_interval;
	
	/**
	 * 
	 * Public
	 * 
	 * ������������� ��������� ����������
	 * 
	 * */
	
	this.init = function() {
		if (this.bitrix_panel.length) {
        	this.popup_container.css("top", this.bitrix_panel.height() + "px");
        }
        
        this.popup_container.on('click', ".close_push_popup", function(e) {
        	var current_popup = $(e.currentTarget).parents(".push_message");
        	this._closePopup(current_popup);
        }.bind(this));
	}
	
	/**
	 * 
	 * Public
	 * 
	 * ���������� ��� ��������� ������ ����
	 * @param string header
	 * @param string message
	 * @return void
	 * 
	 * */
	this.onNewPush = function(header, message) {
		!this.pulse_interval ? this._startPulse() : "";
		this._renderNewPopup(header, message);
	}
	
	/**
	 * 
	 * Private
	 * 
	 * ��������� ������� favicon � title
	 * 
	 * @return void
	 * 
	 * */
	this._startPulse = function() {
		this.pulse_interval = setInterval(function() {
			var head = document.getElementsByTagName('head')[0],
				links = head.getElementsByTagName('link'),
				link = document.createElement('link');
		 
			// ������ � ������ ������ favicon � title �� ���� HEAD
			for (var i = 0; i < links.length; i++) {
			    var lnk = links[i];
			    if (lnk.rel == 'shortcut icon') {
			        head.removeChild(lnk);
			    }
			}
			$("title").remove();
			
			// ��������� ����� favicon � title � �������� �������
			link.setAttribute('type', 'image/x-icon');
			link.setAttribute('rel', 'shortcut icon');
			
			link.setAttribute('href', this.unchecked_push ? this.default_favicon : this.new_push_favicon);
			$("head").append("<title>" + (this.unchecked_push ? this.default_title : this.new_push_title) + "</title>");
			head.appendChild(link);
			this.unchecked_push ? this.unchecked_push-- : this.unchecked_push++;
		}.bind(this), 1000);
	}
	
	/**
	 * 
	 * Private
	 * 
	 * ������������� ������� favicon � title
	 * 
	 * @return void
	 * 
	 * */
	this._stopPulse = function() {
		clearInterval(this.pulse_interval);
		this.pulse_interval = 0;
	}
	
	/**
	 * 
	 * Private
	 * 
	 * ������������� ��������� favicon � title
	 * 
	 * @return void
	 * 
	 * */
	this._setDefault = function() {
		var head = document.getElementsByTagName('head')[0],
			links = head.getElementsByTagName('link'),
			link = document.createElement('link');
		
		this.unchecked_push = 0;
	 
		// ������ � ������ ������ favicon � title �� ���� HEAD
		for (var i = 0; i < links.length; i++) {
		    var lnk = links[i];
		    if (lnk.rel == 'shortcut icon') {
		        head.removeChild(lnk);
		    }
		}
		$("title").remove();
		
		// ��������� ��������� favicon � title
		link.setAttribute('type', 'image/x-icon');
		link.setAttribute('rel', 'shortcut icon');
		
		link.setAttribute('href', this.default_favicon);
		$("head").append("<title>" + this.default_title+ "</title>");
		head.appendChild(link);
	}
	
	/**
	 * 
	 * Private
	 * 
	 * ���������� ����� popup
	 * 
	 * @param string header
	 * @param string message
	 * @return void
	 * 
	 * */
	this._renderNewPopup = function(header, message) {
		var rendered_template = this.popup_template.replace("<%=popup_header%>", header).replace("<%=popup_message%>", message);
		this.popup_container.append(rendered_template);
		this.popup_container.children().last().css({
			'opacity' : '1'
		});
	}
	
	/**
	 * 
	 * Private
	 * 
	 * ��������� popup
	 * 
	 * @param object element
	 * @return void
	 * 
	 * */
	this._closePopup = function(element) {
		element.css({
    		'opacity': '0',
    	});
    	setTimeout(function(){
    		element.remove();
    		// ���� ������� ������ �� ��������, �� ��������� ������ � ���������� ��� � ��������� ���������
    		if (!this.popup_container.children().length) {
    			this._stopPulse();
    			this._setDefault();
    		} 
    	}.bind(this), 350);
	}
}
