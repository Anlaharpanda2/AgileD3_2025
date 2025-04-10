<template>
    <div class="login-container">
        <div class="login-card">
            <h1 class="login-title">Contoh Login</h1>
            <p class="login-subtitle">silahkan login ke akun ny</p>
            <form @submit.prevent="handleLogin">
                <div class="form-group">
                    <label for="nik">NIK</label>
                    <input type="text" id="nik" v-model="nik" placeholder="Enter your NIK" required />
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" v-model="username" placeholder="Enter your Username" required />
                </div>
                <button type="submit" class="login-button">Login</button>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            nik: '',
            username: '',
        };
    },
    methods: {
        handleLogin() {
            // Handle login logic here
            alert(`NIK: ${this.nik}, Username: ${this.username}`);
        },
    },
};
</script>

<style scoped>
.login-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #ffe4e6; /* Pastel pink background */
}

.login-card {
    background-color: #ffffff; /* White card */
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    text-align: center;
    width: 100%;
    max-width: 400px;
}

.login-title {
    font-size: 2rem;
    font-weight: bold;
    color: #ff6b81; /* Pink pastel text */
    margin-bottom: 0.5rem;
}

.login-subtitle {
    font-size: 1rem;
    color: #ff6b81;
    margin-bottom: 1.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
    text-align: left;
}

label {
    display: block;
    font-size: 0.9rem;
    color: #ff6b81;
    margin-bottom: 0.5rem;
}

input {
    width: 100%;
    padding: 0.8rem;
    border: 1px solid #ff6b81;
    border-radius: 8px;
    font-size: 1rem;
    color: #333;
    outline: none;
}

input:focus {
    border-color: #ff4d6d;
    box-shadow: 0 0 4px rgba(255, 109, 129, 0.5);
}

.login-button {
    background-color: #ff6b81;
    color: #ffffff;
    padding: 0.8rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.login-button:hover {
    background-color: #ff4d6d;
}

@media (max-width: 480px) {
    .login-card {
        padding: 1.5rem;
    }

    .login-title {
        font-size: 1.5rem;
    }

    .login-subtitle {
        font-size: 0.9rem;
    }
}
</style>