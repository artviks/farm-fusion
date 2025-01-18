import axios from "axios";

// Create an Axios instance
const axiosInstance: AxiosInstance = axios.create({
    baseURL: "http://localhost:8080/api/", // Replace with your API's base URL
    timeout: 10000, // Optional: Timeout after 10 seconds
    headers: {
        "Content-Type": "application/json",
    },
});

// Request interceptor
axiosInstance.interceptors.request.use(
    (config) => {
        // Add authorization token or other custom headers
        const token = localStorage.getItem("authToken");
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    },
    (error) => Promise.reject(error)
);

// Response interceptor
axiosInstance.interceptors.response.use(
    (response) => response,
    (error) => {
        // Handle errors globally
        console.error(error.response || "Unknown Error");
        return Promise.reject(error);
    }
);

export default axiosInstance;