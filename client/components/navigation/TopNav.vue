<template>
	<v-toolbar>
	    <v-toolbar-title>
	    	Trax
	    </v-toolbar-title>

	    <v-spacer></v-spacer>

	    <v-toolbar-items>
			<v-btn flat>Login</v-btn>

			<v-btn color="primary">Register</v-btn>

		    <v-menu offset-y>
				<v-btn
					slot="activator"
					color="primary"
					dark
				>
					Paul Bovis

					<v-icon>expand_more</v-icon>
				</v-btn>
      
				<v-list>
					<v-list-tile
						@click=""
					>
						<v-list-tile-title>Logout</v-list-tile-title>
					</v-list-tile>
				</v-list>
			</v-menu>
	    </v-toolbar-items>
  	</v-toolbar>
</template>