$(document).ready(function(){
	$(".search-button").click(function(){
		$("#pagenumber-hidden").val("1");
		onNeedDataSource();
	});

	$(".clear-button").click(function(){
		$("#username3").val("");
		$("#name3").val("");
		$("#pagenumber-hidden").val("1");
		onNeedDataSource();
	});
	
	$(".add-button").click(function(){
		onNewClicked();
	});
	
	$("#pagesize").change(function(){
		$("#pagenumber-hidden").val("1");
		onNeedDataSource();
	});
});

function generateRandomPassword(){
	$.ajax({
		method: "POST",
		url: "/Api/getRandomPassword/",
		success: function(data) {	
			$("#modal-password").val(data);
			$("#modal-password").focus();
		},
		error: function(data) {
			console.log(data);
		}
	});
}
	
function onNeedDataSource() {
	$.ajax({
		method: "POST",
		url: "/Api/usersOnNeedDataSource/",
		data: { 
			pagesize: $("#pagesize").val(), 
			pagenumber: $("#pagenumber-hidden").val(),
			searchusername: $("#username3").val(),
			searchname: $("#name3").val(),
			sorting: sorting
		},
		success: function(data) {
			var d = JSON.parse(data);
			
			numberOfPages = d.numberOfPages;
			$(".grid-table tbody").empty();
			for(var i = 0; i < d.items.length;i++){
				var user = d.items[i];
				var r = "<tr class='grid-table-row-clickable' id='" + user.id + "' data-toggle='modal' data-target='#userModal'>" + 
				"<td>" + user.username + "</td>" + 
				"<td>" + user.name + "</td>" + 
				"<td>" + user.email + "</td>" + 
				"<td>" + user.activeJn + "</td>" + 
				"<td style='display:none;'>" + JSON.stringify(user) + "</td>" +
				"</tr>";
			
				$(".grid-table tbody").append(r);
			}
			
			$("ul.pagination").empty();
			$("ul.pagination").append("<li class='page-item'><a class='page-link grid-first' href='#'><<</a></li>");
			$("ul.pagination").append("<li class='page-item'><a class='page-link grid-prev' href='#'><</a></li>");
			
			var start  = d.pagenumber;
			if(d.pagenumber > 1)
				start--;
			var end = 4;
			if(d.numberOfPages < end)
				end = d.numberOfPages;
			
			end += start;
			if(end > d.numberOfPages)
			{
				end = d.numberOfPages;
				start = d.numberOfPages - 4;
				if(start < 1)
					start = 1;
			}
			for(var i = start;i <= end; i++){
				var item = "<li class='page-item pagenumber-button";
				if(i == d.pagenumber) {
					item += " active";
				}
				item += "'><a class='page-link' href='#'>" + i + "</a></li>";
				$("ul.pagination").append(item);
			}
			
			$("ul.pagination").append("<li class='page-item'><a class='page-link grid-next' href='#'>></a></li>");
			$("ul.pagination").append("<li class='page-item'><a class='page-link grid-last' href='#'>>></a></li>");
		},
		error: function(data) {
			console.log(data);
		}
	});
}	