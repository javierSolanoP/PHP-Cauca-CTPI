<template>
  <div class="content">
    <div class="row">
      <div class="col-md-8">
        <edit-profile-form >
          <!-- :model="model" -->
        </edit-profile-form>
      </div>
      <div class="col-md-4">
        <user-card ></user-card>
        <!-- :user="user" -->
      </div>
    </div>
  </div>
</template>
<script>


import EditProfileForm from "./Profile/EditProfileForm.vue";
import UserCard from "./Profile/UserCard.vue";

export default {
  components:{
    EditProfileForm,
    UserCard
  },
}
</script>
<style>
</style>
