var numberOfPages;
var sorting;

$(document).ready(function(){
	onNeedDataSource();
	
	$(document).on("click", ".grid-table-row-clickable", function(){
		var row = $(this);
		onRowClicked(row.attr("id"), row);
	});
	
	$(document).on("click", ".table-sortable-column", function(){
		var column = $(this);
		var colNumber = column.attr("id").split("-")[2];
		
		$(".fa-caret-down").hide();
		$(".fa-caret-up").hide();
		
		if(!sorting || sorting == "" || sorting.indexOf(colNumber) != 0){
			$(".header-up-col-" + colNumber).show();
			sorting = colNumber + " ASC";
		}
			
		else if (sorting == colNumber + " ASC"){
			$(".header-down-col-" + colNumber).show();
			sorting = colNumber + " DESC";
		}
			
		else if (sorting == colNumber + " DESC"){
			sorting = "";
		}
		
		$("#pagenumber-hidden").val("1");
		onNeedDataSource();
	});
	
	$(document).on("click", "ul.pagination li.pagenumber-button", function(e){
		e.preventDefault();
		 var current = $(this);
		 $(".i.pagenumber-button").each(function(){
			 $(this).removeClass("active");
		 });
		 current.addClass("active");
	   $("#pagenumber-hidden").val($(this).find("a").text());
	   onNeedDataSource();
	});
	
	$(document).on("click", ".grid-next", function(e){
		e.preventDefault();
		var oldValue = parseInt($("#pagenumber-hidden").val());
	
		if(oldValue < numberOfPages)
			oldValue++;
		$("#pagenumber-hidden").val(oldValue);
		
		onNeedDataSource();
	});
	
	$(document).on("click", ".grid-prev", function(e){
		e.preventDefault();
		var oldValue = parseInt($("#pagenumber-hidden").val());
			
		if(oldValue > 1)
			oldValue--;
		$("#pagenumber-hidden").val(oldValue);
		onNeedDataSource();
	});
	
	$(document).on("click", ".grid-first", function(e){
		e.preventDefault();
		$("#pagenumber-hidden").val(1);
		onNeedDataSource();
	});
	
	$(document).on("click", ".grid-last", function(e){
		e.preventDefault();
		$("#pagenumber-hidden").val(numberOfPages);
		onNeedDataSource();
	});
});