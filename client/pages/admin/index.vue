<template>
    <section class="section">
    	<div class="container">
    		<b-tabs v-model="activeTab">
	            <b-tab-item label="Users">
	                <UsersTab />
	            </b-tab-item>

	            <b-tab-item label="Courses">
	                <CoursesTab />
	            </b-tab-item>
	        </b-tabs>
    	</div>
    </section>
</template>

<script>
	import UsersTab from '../../components/admin/tabs/UsersTab'
	import CoursesTab from '../../components/admin/tabs/CoursesTab'

	export default {
		middleware: ['admin'],

		components: {
			UsersTab,
			CoursesTab
		},

		data() {
            return {
                activeTab: 0,
                showBooks: false
            }
        }
	}
</script>