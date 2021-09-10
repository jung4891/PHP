jQuery(function($){
	var tree_menu = $('#tree_menu');
	var icon_open = '/dbs/misc/img/tree_open.gif';
	var icon_close = '/dbs/misc/img/tree_close.gif';
	
	tree_menu.find('li:has("ul")').prepend('<a href="#" class="control"><img src="' + icon_close + '" /></a> ');
	tree_menu.find('li:last-child').addClass('end');
	
	$('.control').click(function(){
		var temp_el = $(this).parent().find('>ul');
		if (temp_el.css('display') == 'none'){
			temp_el.slideDown(100);
			$(this).find('img').attr('src', icon_close);
			return false;
		} else {
			temp_el.slideUp(100);
			$(this).find('img').attr('src', icon_open);
			return false;
		}
	});
	
	function tree_init(status){
		if (status == 'close'){
			tree_menu.find('ul').hide();
			$('a.control').find('img').attr('src', icon_open);
		} else if (status == 'open'){
			tree_menu.find('ul').show();
			$('a.control').find('img').attr('src', icon_close);
		}

		//$( "#tree_menu" ).sortable({
		  //revert: true
		//});

/*
		$('#tree_menu li').draggable({
		  //connectToSortable: "#tree_menu",
		  //helper: "clone",
		  revert: "invalid",
		  axis: 'y'
		  
		});
		
		//$( "ul, li" ).disableSelection();

		
		$('#tree_menu').droppable({
			accept: 'li',
			tolerance: 'pointer',
			//tolerance: 'fit',
			drop: function (event, ui) {
				//alert('inside');
                //var $this = $(this);
                //cleanupHighlight(ui, $this);
                //var $new = $this.clone().children("li")
                //                .html(ui.draggable.html()).end();
                //if (isInUpperHalf(ui, $this)) {
                //    $new.insertBefore(this);
                //} else {
                //    $new.insertAfter(this);
                //}
                //initDroppable($new);
				//alert($(this).clone().children("li").html());
				
				//alert($(ui.draggable).parents().first().html())
				//alert($(ui.draggable).parents().first().html())
				//alert($(ui.draggable).parents().first().html())

				//$(ui.draggable).parents().first().insertBefore(ui.draggable);
				//alert(ui.draggable);
				//alert(ui.draggable.html());
			},
			over: function (event, ui) {
				$('#log').text('over');
			},
			out: function (event, ui) {
				$('#log').text('out');
			}
		});
		*/
		
	}
	tree_init('close');
	
	function isInUpperHalf(ui, $droppable)
    {
        var $draggable = ui.draggable || ui.helper;
        return (ui.offset.top + $draggable.outerHeight() / 2
                <= $droppable.offset().top + $droppable.outerHeight() / 2);
    }

    function updateHighlight(ui, $droppable)
    {
        if (isInUpperHalf(ui, $droppable)) {
            $droppable.removeClass("droppable-below")
                      .addClass("droppable-above");
        } else {
            $droppable.removeClass("droppable-above")
                      .addClass("droppable-below");
        }
    }

    function cleanupHighlight(ui, $droppable)
    {
        ui.draggable.removeData("current-droppable");
        $droppable.removeClass("droppable-above droppable-below");
    }


	/* 보기설정 (사용시 삭제) */
	$('#css_use').toggle(function(){
		$('link').attr('href', '');
		$(this).text('CSS (O)');
	},function(){
		$('link').attr('href', 'tree.css');
		$(this).text('CSS (X)');
	});
	$('#all').toggle(function(){
		tree_init('open');
		$(this).text('ALL CLOSE');
	},function(){
		tree_init('close');
		$(this).text('ALL OPEN');
	});
	
});