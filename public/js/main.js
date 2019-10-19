document.getElementById("search").addEventListener('submit', event => {
    event.preventDefault();
    const terms = event.target.terms.value;
    const dupes = event.target.dupes.checked ? '0' : '';
    makeRequest(terms, dupes);
});

let httpRequest;

const makeRequest = (terms, dupes = 'true') => {
    document.getElementById("results").innerHTML = `<p>Loading...</p>`;
    httpRequest = new XMLHttpRequest();

    if (!httpRequest) {
        document.getElementById("results").innerHTML = `<p>An error occured.</p>`;
        return false;
    }
    httpRequest.onreadystatechange = showContents;
    httpRequest.open('GET', `/users?terms=${terms}&dupes=${dupes}`);
    httpRequest.send();
}

const showContents = () => {
    if (httpRequest.readyState === XMLHttpRequest.DONE) {
        if (httpRequest.status === 200) {
            const response = JSON.parse(httpRequest.responseText);
            if (response.length < 1) {
                document.getElementById("results").innerHTML = `<p>No results found.</p>`;
                return;
            }

            let html = '';
            response.forEach(item => html += `<li>${item.firstName} ${item.lastName}</li>`);
            document.getElementById("results").innerHTML = `<ul>${html}</ul>`;
        } else {
            document.getElementById("results").innerHTML = `<p>There was a problem with the request.</p>`;
        }
    }
}
