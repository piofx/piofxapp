<x-dynamic-component :component="$app->componentName" class="mt-4" >
	<div class="page_wrapper">
		<div class="page_container">
			
			 <div class="bg-white p-5 rounded-lg mt-3">
		        <h3 class="p-3 rounded-sm border bg-light">Whatsapp Message</h3>
		        <form action="{{ route('whatsapp')}}" class="bg-light p-5 mt-3 rounded-lg">
		            <h4 class="mb-3">Maintenance</h4>
		            <label>Phone numbers (separated by commas) </label>
		            <input type="text" name="phone" class="form-control mb-3" placeholder="enter phone numbers">

		             <label>Template name </label>
		            <input type="text" name="template" class="form-control mb-3" placeholder="enter templates name">

		             <label>$1 </label>
		            <input type="text" name="v1" class="form-control mb-3" placeholder="variable 1">

		            <label>$2 </label>
		            <input type="text" name="v2" class="form-control mb-3" placeholder="variable 2">
		            
		            <input type="hidden" name="send" class="form-control mb-3" value="1">
		            
		            <button type="submit" class="btn btn-dark mt-3">Send message</button>
		        </form>
		    </div>

		</div>
	</div>
</x-dynamic-component>