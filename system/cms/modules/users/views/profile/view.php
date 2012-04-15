<h2 class="page-title">{{ user:display_name user_id= _user:id }}</h2>


<!-- Container for the user's profile -->
<div id="user_profile_container">
	<?php echo gravatar($_user->email, 50);?>
	<!-- Details about the user, such as role and when the user was registered -->
	<div id="user_details">

		<table>
	
			{{# we use _user:id as that is the id passed to this view. Different than the logged in user's user:id #}}
			{{ user:profile_fields user_id= _user:id }}
				{{#   viewing own profile?    are they an admin?        ok it's a regular user, we'll show the non-sensitive items #}}
				{{ if user:id === _user:id or user:group === 'admin' or slug != 'email' and slug != 'first_name' and slug != 'last_name' and slug != 'username' and value }}
					<tr><td><strong>{{ name }}:</strong></td><td>{{ value }}</td></tr>
				{{ endif }}

			{{ /user:profile_fields }}

		</table>

	</div>
	

</div>