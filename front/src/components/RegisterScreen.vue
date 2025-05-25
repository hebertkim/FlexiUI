<template>
  <div class="flex flex-col items-center justify-center min-h-screen bg-gray-50">

    <!-- Sign Up Card -->
    <div class="w-full max-w-md p-4 bg-white rounded-lg shadow-md">

      <!-- Logo -->
      <div class="mb-6 mt-2">
        <img src="/default-logo.png" alt="Logo" class="w-16 h-16 mx-auto rounded-full shadow-md" />
      </div>

      <h2 class="mb-6 text-2xl font-bold text-center text-gray-800">Create Account</h2>

      <!-- Input Fields -->
      <form @submit.prevent="onSubmit">
        <div class="mb-4">
          <label for="name" class="block mb-1 text-sm font-medium text-gray-700">Full Name</label>
          <input id="name" type="text" v-model="name"
            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-300"
            placeholder="Enter your full name" required />
        </div>

        <div class="mb-4">
          <label for="email" class="block mb-1 text-sm font-medium text-gray-700">Email</label>
          <input id="email" type="email" v-model="email" autocomplete="email"
            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-300"
            placeholder="Enter your email" required />
        </div>

        <!-- Password Fields -->
        <div class="mb-4">
          <label for="password" class="block mb-1 text-sm font-medium text-gray-700">Password</label>
          <input id="password" type="password" v-model="password" autocomplete="new-password"
            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-300"
            placeholder="Enter your password" required />
        </div>

        <div class="mb-4">
          <label for="confirmPassword" class="block mb-1 text-sm font-medium text-gray-700">Confirm Password</label>
          <input id="confirmPassword" type="password" v-model="confirmPassword" autocomplete="new-password"
            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-300"
            placeholder="Confirm your password" required />
        </div>

        <!-- Submit Button -->
        <button type="submit"
          class="w-full px-4 py-2 mb-4 text-white bg-gray-500 rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring focus:ring-red-300">
          Create Account
        </button>
        <p class="mb-6 text-sm text-left text-gray-600">
          Already have an account?
          <a href="/login" class="text-blue-500 hover:underline">Log in</a>
        </p>
      </form>
    </div>
  </div>
</template>

<script>
import api from '@/services/api';

export default {
  name: "RegisterScreen",

  components: {
  },

  data() {
    return {
      name: "",
      email: "",
      password: "",
      confirmPassword: "",
    };
  },

  methods: {
    async onSubmit() {
      console.log("Registration form submitted");

      // Password validation
      if (this.password !== this.confirmPassword) {
        console.log("Passwords do not match");
        alert("Passwords do not match!");
        return;
      }

      // Form data
      const formData = {
        name: this.name,
        email: this.email,
        password: this.password,
        password_confirmation: this.confirmPassword,
      };

      try {
        console.log("Sending data to the API...");
        const response = await api.post('/user', formData);

        if (response.status === 200 || response.status === 201) {
          console.log("Registration successful:", response);
          alert('Registration successful!');
          this.resetForm();

          // Check and redirect
          if (this.$router) {
            console.log("Redirecting to /login");
            this.$router.push('/login');
          } else {
            console.error("Vue Router is not available.");
            alert("Unable to redirect. Check the Vue Router configuration.");
          }
        }
      } catch (error) {
        console.error("Error during registration:", error);
        alert("Registration error, please try again later.");
      }
    },

    resetForm() {
      console.log("Resetting form");
      this.name = "";
      this.email = "";
      this.password = "";
      this.confirmPassword = "";
    },
  },
};
</script>

<style scoped>
/* Add additional styles if necessary */
</style>
