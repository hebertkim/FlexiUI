<template>
  <div class="flex flex-col items-center justify-center min-h-screen bg-gray-50">

    <div class="w-full max-w-md p-4 bg-white rounded-lg shadow-md">

      <!-- Logo -->
      <div class="mb-6 mt-2">
        <img src="/default-logo.png" alt="Logo" class="w-16 h-16 mx-auto rounded-full shadow-md" />
      </div>

      <!-- Login Card -->
      <h2 class="mb-6 text-2xl font-bold text-center text-gray-800">Login</h2>

      <!-- Input Fields -->
      <form @submit.prevent="onSubmit">
        <div class="mb-4">
          <label for="email" class="block mb-1 text-sm font-medium text-gray-700">Email or username</label>
          <input id="email" type="email" v-model="email"
            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-300"
            placeholder="Enter your email" required />
        </div>

        <div class="mb-6">
          <label for="password" class="block mb-1 text-sm font-medium text-gray-700">Password</label>
          <input id="password" type="password" v-model="password"
            class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-300"
            placeholder="Enter your password" required />
        </div>

        <!-- Submit Button -->
        <button type="submit"
          class="w-full px-4 py-2 mb-4 text-white bg-gray-500 rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring focus:ring-red-300">
          Log In
        </button>
      </form>

      <!-- Sign Up Prompt -->
      <p class="text-sm text-left text-gray-600">
        Don't have an account?
        <router-link to="/register" class="text-blue-500 hover:text-blue-700">Create Account</router-link>
      </p>
    </div>
  </div>
</template>

<script>
import api from "@/services/api";

export default {
  name: "LoginView",
  data() {
    return {
      email: "",
      password: "",
      loading: false,
    };
  },
  methods: {
    async onSubmit() {
      try {
        this.loading = true;
        const response = await api.post("/login", {
          email: this.email,
          password: this.password,
        });

        if (response.data.success) {
          localStorage.setItem("authToken", response.data.token);
          localStorage.setItem("userName", response.data.user.name);
          this.$router.push("/");
        } else {
          alert(response.data.message || "Login failed. Please try again.");
        }
      } catch (error) {
        console.error("Error trying to log in:", error);
        alert("Error connecting to the server. Please try again.");
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>

<style scoped>
/* Add additional styles if necessary */
</style>
