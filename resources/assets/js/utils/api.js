const apiCall = ({url, data, method}) => new Promise((resolve, reject) => {
  setTimeout(() => {
    try {
      
      axios.defaults.headers.common['Authorization'] = localStorage.getItem('user-token');
      if (method == 'GET') {
        axios.get(url).then(({data}) => {
          resolve(data)
        }).catch(({response}) => {
          reject(new Error(response))
        })
      } else if (method == 'POST'){
        axios.post(url,data).then(({data}) => {
          resolve(data)
        }).catch(({response}) => {
          reject(new Error(response))
        });
      } else if (method == 'PUT'){
        axios.put(url,data).then(({data}) => {
          resolve(data)
        }).catch(({response}) => {
          reject(new Error(response))
        });
      } else if (method == 'DELETE'){
        axios({ method: 'delete', url: url,data: null})
        .then(({data}) => {
          resolve(data)
        }).catch(({response}) => {
          reject(new Error(response))
        });
      }
    } catch (err) {
      reject(new Error(err))
    }
  }, 1000)
})

export default apiCall