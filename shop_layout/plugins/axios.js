export default function({ $axios, redirect }) {
    /**
     * Interceptor on request
     */
    $axios.onRequest(config => {
      return config;
    });
  
    /**
     * Interceptor on response
     */
    $axios.onResponse(response => {
      return response.data;
    });
  
    /**
     * Interceptor on error
     */
    $axios.onError(error => {
      const code = parseInt(error.response && error.response.status);
      // Handle error
      return Promise.reject(error.response.data);
    });
  }