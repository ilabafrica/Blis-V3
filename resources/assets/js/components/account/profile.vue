<template>
	<div>
		<v-dialog v-model="dialog" max-width="500px">
	      <v-card>
	        <v-toolbar dark color="primary" class="elevation-0">
	          <v-toolbar-title>Upload an Image</v-toolbar-title>
	          <v-spacer></v-spacer>
	          <v-btn round outline color="blue lighten-1" flat @click.native="dialog=false">
	            Cancel
	            <v-icon right dark>close</v-icon>
	          </v-btn>
	        </v-toolbar>
	        <v-form ref="form" v-model="valid" lazy-validation>
	        <v-card-text>
	          <v-container grid-list-md>
	            <v-layout wrap>
	              <v-flex xs12 sm12 md12>
	              	<img :src="imageUrl" height="150" v-if="imageUrl"/>
	                <v-text-field
	                  :rules="[v => !!v || 'File is required']"
	                  label="Select Image"
	                  @click='pickFile'
	                  v-model='imageName'
	                  prepend-icon='attach_file'>
	                </v-text-field>
	                <input
						type="file"
						style="display: none"
						ref="image"
						accept="image/*"
						@change="onFilePicked"
					>
	              </v-flex>
	               <v-flex xs3 offset-xs9 text-xs-right>
	              <v-btn round outline xs12 sm6 color="blue darken-1" :disabled="!valid" @click.native="submitFile">
	                Save <v-icon right dark>cloud_upload</v-icon>
	              </v-btn>
	               </v-flex>
	            </v-layout>
	          </v-container>
	        </v-card-text>
	        <v-card-actions>
	        </v-card-actions>
	        </v-form>
	      </v-card>
	    </v-dialog>
    <v-tabs
      color="blue"
      dark
      slider-color="white"
    >
      <v-tab
        ripple
      >
        Edit Profile
      </v-tab>
      <v-tab-item>
        <v-card flat>
          <v-layout>
	    <v-flex xs6 sm6>
	    	<v-alert
		      v-model="mainalert"
		      outline
		      align-right
		      icon="done"
		      transition="scale-transition"
		      color="green"
		      dismissible>
		      {{message}}
		    </v-alert>
		  	<v-card>
			  	<v-form ref="form" v-model="valid" lazy-validation>
				    <v-card-text>
				      <v-container grid-list-md>
				        <v-layout wrap>
				          <v-flex xs12 sm12 md12>
				            <v-text-field
				            	disabled
				              v-model="editedItem.username"
				              :rules="[v => !!v || 'Username is Required']"
				              label="Username">
				            </v-text-field>
				          </v-flex>
				          <v-flex xs12 sm12 md12>
				            <v-text-field
				              v-model="editedItem.name"
				              :rules="[v => !!v || 'Full Name is Required']"
				              label="Full Name">
				            </v-text-field>
				          </v-flex>
				          <v-flex xs12 sm12 md12>
				            <v-text-field
				              v-model="editedItem.email"
				              :rules="[v => !!v || 'Email Address is Required']"
				              label="Email Address">
				            </v-text-field>
				          </v-flex>
				          <!-- <v-flex xs12 sm12 md12>
				            <v-text-field 
				              v-model="editedItem.roles.names"
				              :rules="[v => !!v || 'Designation is Required']"
				              label="Designation">
				            </v-text-field>
				          </v-flex> -->
				          <v-flex xs12 sm12 md12>
				            Gender
				            <v-radio-group
				              v-model="editedItem.gender" row
				              >
				              <v-radio label="Male" value="2"></v-radio>
				              <v-radio label="Female" value="1"></v-radio>
				            </v-radio-group>
				          </v-flex>
				           <v-flex xs3 offset-xs9 text-xs-right>
				          <v-btn round outline xs12 sm6 color="blue darken-1" :disabled="!valid" @click.native="save">
				            Save <v-icon right dark>cloud_upload</v-icon>
				          </v-btn>
				           </v-flex>
				        </v-layout>
				      </v-container>
				    </v-card-text>
				    <v-card-actions>
				    </v-card-actions>
			    </v-form>
			</v-card>
		</v-flex>
		&nbsp &nbsp
		<v-flex xs6 sm6>
	      <v-card>
	        <img
	          position
	          :src="'uploads/profile_pictures/' +editedItem.profile_picture"
	          height = "320"
	          width = "320"
	        ></img>
	        <v-card-actions>
	          <v-btn flat color="blue" @click.native="upload">Upload</v-btn>
	          <v-btn flat color="blue" @click.native="removePic">Remove</v-btn>
	        </v-card-actions>
	      </v-card>
	    </v-flex>
	</v-layout>

        </v-card>
      </v-tab-item>

      <v-tab
        ripple
      >
        Change Password
      </v-tab>
      <v-tab-item>
        <v-card flat>
          <v-layout>
	    <v-flex xs6 sm6 offset-sm3>
		  	<v-card>
			  	<v-form ref="form" v-model="valid" lazy-validation>
				    <v-card-text>
				      <v-container grid-list-md>
				        <v-layout wrap>
				        	<v-alert
						      v-model="alert"
						      outline
						      align-right
						      icon="warning"
						      transition="scale-transition"
						      color="error"
						      dismissible>
						      {{message}}
						    </v-alert>
						    <v-alert
						      v-model="successalert"
						      outline
						      align-right
						      icon="done"
						      transition="scale-transition"
						      color="green"
						      dismissible>
						      {{message}}
						    </v-alert>
				          <v-flex xs12 sm12 md12>
					          <v-text-field
					            :append-icon="show1 ? 'visibility_off' : 'visibility'"
					            :rules="[rules.required, rules.min]"
					            :type="show1 ? 'text' : 'password'"
					            name="input-10-2"
					            label="Current Password"
					            v-model="editedItem.password"
					            class="input-group--focused"
					            @click:append="show1 = !show1"
					          ></v-text-field>
					        </v-flex>
				          <v-flex xs12 sm12 md12>
					          <v-text-field
					            :append-icon="show2 ? 'visibility_off' : 'visibility'"
					            :rules="[rules.required, rules.min]"
					            :type="show2 ? 'text' : 'password'"
					            name="newpassword"
					            label="New Password"
					            v-model="editedItem.newpassword"
					            class="input-group--focused"
					            @click:append="show2 = !show2"
					          ></v-text-field>
					        </v-flex>
					        <v-flex xs12 sm12 md12>
					          <v-text-field
					            :append-icon="show3 ? 'visibility_off' : 'visibility'"
					            :rules="[rules.required, rules.min, rules.passwordMatch]"
					            :type="show3 ? 'text' : 'password'"
					            name="confirmpassword"
					            label="Confirm Password"
					            v-model="editedItem.confirmpassword"
					            class="input-group--focused"
					            @click:append="show3 = !show3"
					          ></v-text-field>
					        </v-flex>
				           <v-flex xs3 offset-xs9 text-xs-right>
				          <v-btn round outline xs12 sm6 color="blue darken-1" :disabled="!valid" @click.native="savePassword">
				            Save <v-icon right dark>cloud_upload</v-icon>
				          </v-btn>
				           </v-flex>
				        </v-layout>
				      </v-container>
				    </v-card-text>
				    <v-card-actions>
				    </v-card-actions>
			    </v-form>
			</v-card>
		</v-flex>
	</v-layout>

        </v-card>
      </v-tab-item>
    </v-tabs>

  	
  </div>
</template>
<script>
	import apiCall from '../../utils/api'

  export default {
  	data: () => ({
  		dialog: false,
  		mainalert: false,
  		alert: false,
  		successalert: false,
  		valid: true,
  		password: false,
  		message: '',
  		removePicture: false,
  		show1: false,
  		show2: false,
  		show3: false,
  		imageName: '',
		imageUrl: '',
		imageFile: '',
  		rules: {
          required: value => !!value || 'Required.',
          min: v => v.length >= 8 || 'Min 8 characters',
          passwordMatch: v => (v==this.editedItem.newpassword) ||'The new password and confirmation password you entered do not match'
        },
  		editedItem: [],
  	}),

  	methods: {
  		initialize () {
        apiCall({url: '/api/get-user', method: 'GET'})
	         .then(resp => {
	           console.log(resp)
	           this.editedItem = resp;
	           if (resp.profile_picture == null) {
	           	this.editedItem.profile_picture = 'default-profile-picture.jpg'
	           }
	           
	         })
	         .catch(error => {
	           console.log(error.response)
	         })
      },

      savePassword(){
      	this.password = true
      	this.save()
      },
      upload (){
      	this.dialog = true
      },
      removePic (){
      	this.removePicture = true;
      	this.editedItem.removePic = true;
      	this.save()
      },
      pickFile () {
	    this.$refs.image.click ()
	  },
	  onFilePicked (e) {
			const files = e.target.files
			if(files[0] !== undefined) {
				this.imageName = files[0].name
				if(this.imageName.lastIndexOf('.') <= 0) {
					return
				}
				const fr = new FileReader ()
				fr.readAsDataURL(files[0])
				fr.addEventListener('load', () => {
					this.imageUrl = fr.result
					this.imageFile = files[0] // this is an image file that can be sent to server...
				})
			} else {
				this.imageName = ''
				this.imageFile = ''
				this.imageUrl = ''
			}
		},
	submitFile(){
		let formData = new FormData();
		formData.append('id', this.editedItem.id);
		formData.append('name', this.imageName);
		formData.append('file', this.imageFile);
		const config = {
            headers: { 'content-type': 'multipart/form-data' }
        }
		console.log(formData)
		apiCall({url: '/api/user/image',
			data: formData,
			config,
			method: 'POST', 
			
			  })
	          .then(resp => {
	          	console.log(resp)
	          	this.editedItem.profile_picture = resp.profile_picture;
	          	this.dialog = false;
	          	this.imageName = '';
	          	this.imageFile = '';
	          	this.imageUrl = '';
            	this.mainalert = true;
            	this.message = 'Profile Updated Successfully'
	          })
	          .catch(error => {
	            /*this.message = 'The current password is incorrect';
            	this.alert = true;*/
	          })
	},

      save () {
      	if (this.password){
      		if (this.editedItem.confirmpassword != this.editedItem.newpassword){
      			this.message = 'The new password does not match the confirmation password';
      			this.successalert = false;
            	this.alert = true;
      		}else{
      		this.editedItem.passwordChange = true
      		apiCall({url: '/api/user/'+this.editedItem.id, data: this.editedItem, method: 'PUT' })
	          .then(resp => {
	          	console.log(resp)
	          	this.message = 'Success';
	          	this.alert = false;
            	this.successalert = true;
	          })
	          .catch(error => {
	            this.message = 'The current password is incorrect';
            	this.alert = true;
	          })
	      }
      	}else{

      	apiCall({url: '/api/user/'+this.editedItem.id, data: this.editedItem, method: 'PUT' })
          .then(resp => {
            Object.assign(this.editedItem)
            console.log(resp)
            if (this.removePicture){
            	this.editedItem.profile_picture = 'default-profile-picture.jpg'
            	this.removePicture = false
            }
            this.mainalert = true;
            this.message = 'Profile Updated Successfully'
            
          })
          .catch(error => {
            console.log('error', error)
          })
      }
  }
  	},
    created () {
      this.initialize()
    },
  }

</script>