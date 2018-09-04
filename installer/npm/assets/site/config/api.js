const getApiUrl = (path) => {
    const url = 'http://localhost:8000';
    return url + path;
};

export default getApiUrl;