import axiosClient from "../axios";

export function getCurrentUser({commit}, data) {
  return axiosClient.get('/user', data)
    .then(({data}) => {
      commit('setUser', data);
      return data;
    })
}

export function login({commit}, data) {
  console.log(data);
  return axiosClient.post('/login', data)
    .then(({data}) => {
      commit('setUser', data.user);
      commit('setToken', data.token)
      return data;
    })
}

export function logout({commit}) {
  return axiosClient.post('/logout')
    .then((response) => {
      commit('setToken', null)

      return response;
    })
}





export function getPosts({commit, state}, {url = null, search = '', per_page, sort_field, sort_direction} = {}) {
  commit('setPosts', [true])
  url = url || '/posts'
  const params = {
    per_page: state.posts.limit,
  }
  return axiosClient.get(url, {
    params: {
      ...params,
      search, per_page, sort_field, sort_direction
    }
  })
    .then((response) => {
      commit('setPosts', [false, response.data])
    })
    .catch(() => {
      commit('setPosts', [false])
    })
}

export function getPost({commit}, id) {
  return axiosClient.get(`/posts/${id}`)
}

export function createPost({commit}, post) {
  if (post.images && post.images.length) {
    const form = new FormData();
    form.append('title', post.title);
    post.images.forEach(im => form.append('images[]', im))
    form.append('description', post.description || '');
    form.append('published', post.published ? 1 : 0);
    
    post = form;
  }
  return axiosClient.post('/posts', post)
}

export function updatePost({commit}, post) {
  const id = post.id
  if (post.images && post.images.length) {
    const form = new FormData();
    form.append('id', post.id);
    form.append('title', post.title);
    post.images.forEach(im => form.append(`images[${im.id}]`, im))
    if (post.deleted_images) {
      post.deleted_images.forEach(id => form.append('deleted_images[]', id))
    }
    for (let id in post.image_positions) {
      form.append(`image_positions[${id}]`, post.image_positions[id])
    }
    form.append('description', post.description || '');
    form.append('published', post.published ? 1 : 0);
    form.append('_method', 'PUT');
    post = form;
  } else {
    post._method = 'PUT'
  }
  return axiosClient.post(`/posts/${id}`, post)
}

export function deletePost({commit}, id) {
  return axiosClient.delete(`/posts/${id}`)
}

export function getUsers({commit, state}, {url = null, search = '', per_page, sort_field, sort_direction} = {}) {
  commit('setUsers', [true])
  url = url || '/users'
  const params = {
    per_page: state.users.limit,
  }
  return axiosClient.get(url, {
    params: {
      ...params,
      search, per_page, sort_field, sort_direction
    }
  })
    .then((response) => {
      commit('setUsers', [false, response.data])
    })
    .catch(() => {
      commit('setUsers', [false])
    })
}

export function createUser({commit}, user) {
  return axiosClient.post('/users', user)
}

export function updateUser({commit}, user) {
  return axiosClient.put(`/users/${user.id}`, user)
}



