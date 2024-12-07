const express = require('express');
const fetch = require('node-fetch');
const app = express();
app.use(express.json());

app.post('/summarize', async (req, res) => {
    const text = req.body.text;

    const response = await fetch('https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer YOUR_OAUTH2_ACCESS_TOKEN'
        },
        body: JSON.stringify({ text })
    });

    const result = await response.json();
    res.json(result);
});

app.listen(3000, () => {
    console.log('Server running on port 3000');
});
