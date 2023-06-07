import http from 'k6/http';

export let options = {
    insecureSkipTLSVerify: true,
    noConnectionReuse: false,
    vus: 100,
    duration: '10s',
}

export default () => {
    http.get('http://127.0.0.1:8001');
}
