import axios from 'axios';
import.meta.glob("../assets/js/**/*.js", { eager: true });
import.meta.glob("../assets/vendor/js/**/*.js", { eager: true });

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

