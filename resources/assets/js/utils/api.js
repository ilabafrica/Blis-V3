const apiCall = ({url, data, method}) => new Promise((resolve, reject) => {
  setTimeout(() => {
    try {
      
      axios.defaults.headers.common['Authorization'] = localStorage.getItem('user-token');
      if (method == 'GET') {
        axios.get(url).then((response) => {
          resolve(response.data)
        }).catch((response) => {
          reject(new Error(response))
        })
      } else if (method == 'POST'){
        axios.post(url,data).then((response) => {
          resolve(response.data)
        }).catch((response) => {
          reject(new Error(response))
        });
      } else if (method == 'PUT'){
        axios.put(url,data).then((response) => {
          resolve(response.data)
        }).catch((response) => {
          reject(new Error(response))
        });
      } else if (method == 'DELETE'){
        axios({ method: 'delete', url: url,data: null})
        .then((response) => {
          resolve(response.data)
        }).catch((response) => {
          reject(new Error(response))
        });
      }
    } catch (err) {
      reject(new Error(err))
    }
  }, 1000)
})

export default apiCall