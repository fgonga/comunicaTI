import axios from 'axios';

const resource = '/api/tag';

export default {
  index() {
    return axios.get(`${resource}`);
  },
  store(tag) {
    return axios.post(`${resource}`, tag, {
      config: {
        showToast: true,
        responseToast: {
          title: 'Sucesso',
        },
      },
    });
  },
  show(id) {
    return axios.get(`${resource}/${id}`);
  },
  update(payload) {
    const { id } = payload;
    return axios.put(
      `${resource}/${id}`,
      payload,
      {
        config: {
          showToast: true,
          responseToast: {
            title: 'Sucesso',
          },
        },
      },
    );
  },
  destroy(id) {
    return axios.delete(`${resource}/${id}`);
  },
  contacts(id){
    return axios.get(`${resource}/${id}/contacts`);
  }
};
