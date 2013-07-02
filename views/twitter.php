<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Type ahead with codeigniter</title>
    <!-- loading bootstrap main css file -->
    <link href="/bootstrap/css/bootstrap.css" rel="stylesheet">
    <!-- Loading bootstrap responsive css file -->
    <link href="/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
   
</head>
<body>
   <div class="well">
         <!-- Displaying the input text where user will be searching from -->
         <input type="text" class="span3" id="typeahead" data-provide="typeahead" >
        
   </div>
    <div class="well">
 <?php if(isset($result)):?><!-- Did the user search-->
    <?php if(count($result)>0):?><!-- Result are available -->
   <!-- Prepare html table for the available result -->
   <table class="table table-striped"> 
   <thead>
       <tr>
           <th>Person ID</th>
           <th>First name</th>
           <th>Last name</th>
           <th>Phone Number</th>
      </tr>
   </thead>
   <tbody>
    <!-- Display the available result  -->
        <?php foreach ($result as $results) :?>
        <tr>
           <td><?=$results->person_id?></td>
           <td><?=$results->first_name?></td>
           <td><?=$results->last_name?></td>
           <td><?=$results->phone_number?></td>
         </tr>
        <?php endforeach;?>
   </tbody>
   </table>
    <?php endif;?>
   <!-- User hasn't searched yet  -->
    <?php else:?>
         <h2>Type in above box to search for people.</h2>
    <?php endif;?>
 </div>
 
  <!-- loading jquery at the bottom for making page load faster -->
<script src="/bootstrap/js/jquery.js"></script>
  <!-- loading bootstrap.js making page load faster -->
<script src="/bootstrap/js/bootstrap.js"></script>

<?php ?>

<script>
$(function(){
  /**Selecting the element with ID typeahead to be the one with type ahead**/
	$("#typeahead").typeahead({
		source: function (query, process) {
            /**Initializing variables that will help us in our source function**/
		    results = [];
		    map = {};
		    /** Start ajax to search remote data**/
		   $.ajax({
				  type: "POST",/**we are using post method**/
				  url: '/index.php/test/search',/**(url) Controller that is going to return the data**/
				  data: 'query='+query,/**Variable we are submitting with post**/
				  dataType: 'json',/**Data format to return **/
				  async:true,/**Setting async to false means that the statement you are calling has to 
				                complete before the next statement in your function can be called.
				                If you set async: true then that statement will begin it's execution 
				                and the next statement will be called regardless of whether the 
				                async statement has completed yet.**/
				  success: function(datas){ /**Now we have the response from the server as an object **/
					  $.each(datas, function (i, result) {/** for each result we are getting from the server **/
					        map[result.first_name+' '+result.last_name] = result;/** map the first name and last name **/
					        results.push(result.first_name+' '+result.last_name);///** pus the first name and last name  to the results variable**/
					    });
					    process(results); /**process our result back to the source**/
				  }
				});
			}
			,
			/**When user select a suggested element**/
			updater: function (element) {
				    selectedElement = map[element].person_id; /**use the person id and search for it**/
				    document.location = "/index.php/test/search/" + encodeURIComponent(selectedElement);
			    return element;
			},
			matcher: function (item) {
			    if (item.toLowerCase().indexOf(this.query.trim().toLowerCase()) != -1) {
			        return true;
			    }
			},
			sorter: function (items) {
			    return items.sort();
			},
			highlighter: function (item) {
			    var regex = new RegExp( '(' + this.query + ')', 'gi' );
			    return item.replace( regex, "<strong>$1</strong>" );
			}
			
	})
});

</script>

  </body> 
</html>
