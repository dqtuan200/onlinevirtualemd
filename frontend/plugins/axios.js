// plugins/axios.js
export default function ({ $axios, redirect }) {
  $axios.onError(error => {
    if (error.response.status === 401) {
      // Redirect to login page if unauthorized
      redirect('/login')
    }
  })
}