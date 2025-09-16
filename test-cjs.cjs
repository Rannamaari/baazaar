const { default: Anthropic } = require("@anthropic-ai/sdk");
const client = new Anthropic({ apiKey: process.env.ANTHROPIC_API_KEY });
(async () => {
  const resp = await client.messages.create({
    model: "claude-3-5-sonnet-latest",
    max_tokens: 20,
    messages: [{ role: "user", content: "Hello Claude, do you work?" }]
  });
  console.log(resp.content[0].text);
})();
