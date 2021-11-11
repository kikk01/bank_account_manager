export async function jsonFetch(url, params = {}) {
    params = {
        headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
            'X-Requested-With': XMLHttpRequest
        },
        ...params
    }

    const response = await fetch(url, params);

    const data = await response.json();

    return data;
}