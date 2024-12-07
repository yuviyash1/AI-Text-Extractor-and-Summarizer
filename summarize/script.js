document.getElementById('summarizeButton').addEventListener('click', summarizeText);

async function summarizeText() {
    const text = document.getElementById('inputText').value;

    try {
        const response = await fetch('https://article-extractor-and-summarizer.p.rapidapi.com/summarize?url=https%3A%2F%2Ftime.com%2F6266679%2Fmusk-ai-open-letter%2F&lang=en&engine=2', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-RapidAPI-Key': 'c3f72eb5d6msh080ce9c8cf4e93ap1a21c0jsnc472baa28f8f', // Replace with your actual RapidAPI key
                'X-RapidAPI-Host': 'article-extractor-and-summarizer.p.rapidapi.com'
            },
            body: JSON.stringify({ text: text })
        });

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const result = await response.json();
        console.log(result); // Log the entire response for debugging

        // Check and display the summary
        if (result.summary) {
            document.getElementById('summary').innerText = result.summary;
        } else {
            document.getElementById('summary').innerText = 'Summary not found in response.';
        }
    } catch (error) {
        console.error('Error:', error);
        document.getElementById('summary').innerText = 'An error occurred while summarizing the text.';
    }
}