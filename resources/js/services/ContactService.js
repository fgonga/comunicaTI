import axios from 'axios';

const resource = '/api/contact';

export default {
  index() {
    return axios.get(`${resource}`);
  },
  store(cliente) {
    return axios.post(`${resource}`, cliente, {
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
            title: 'SUCESSO',
          },
        },
      },
    );
  },
  destroy(id) {
    return axios.delete(`${resource}/${id}`);
  }
};
