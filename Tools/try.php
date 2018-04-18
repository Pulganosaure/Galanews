<form method="POST" action="#" class="form-inline">
	<div class="row">
		<div class="col">
    		<div class="form-group mb-2">
       			<select name="Ship" class="custom-select custom-select-lg mb-3">
            		<option value="" selected>Tous</option>
		            <option value="Eagle">Eagle</option>
    		        <option value="Imperial-Eagle">Imperial Eagle</option>
        		    <option value="Annaconda">Annaconda</option>
            		<option value="Imperial-Eagle">Imperial Eagle</option>
	            	<option value="Imperial-Courrier">Imperial Courrier</option>
    	        	<option value="Imperial-Clipper">Imperial Clipper</option>
        	   		<option value="Imperial-Cutter">Imperial Cutter</option>
          		</select>
        	</div>		
		</div>
		<div class="col">	
        	<div class="form-group mb-2">
          	<select name="Category" class="custom-select custom-select-lg mb-3">
            	<option value="" selected>Tous :</option>
            	<option value="Exploration">Exploration</option>
            	<option value="Combat">Combat</option>
            	<option value="Marchand">Marchand</option>
            	<option value="Chasse aux xenomorphes">Chasse aux xenomorphes</option>
            	<option value="Scientifique">Scientifique</option>
            	<option value="Multi-Roles">Multi-Roles</option>  
            	<option value="Autre">Autre</option>
          	</select>
        	</div>
		</div>
	</div>
	<div class="row">
		<div class="col">
      		<div class="col">
        		<button type="submit" class="btn btn-primary">Chercher</button>
      		</div>		
		</div>
</form>
		<div class="col">
    		<form action="Add_Coriolis_fit.php">
      			<button type="submit" class="btn btn-primary">Ajouter un fit</button>
    		</form>		
		</div>
	</div>