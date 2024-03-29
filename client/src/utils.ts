const regex = /("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g;

export function syntaxHighlight(jsonstring: string): string {
    // from https://stackoverflow.com/a/7220510/
    jsonstring = jsonstring.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;");
    return jsonstring.replace(regex, (match: string) => {
        let cls = "number";
        if (/^"/.test(match)) {
            if (/:$/.test(match)) {
                cls = "key";
            } else {
                cls = "string";
            }
        } else if (/true|false/.test(match)) {
            cls = "boolean";
        } else if (/null/.test(match)) {
            cls = "null";
        }
        return "<span class=\"" + cls + "\">" + match + "</span>";
    });
}


export function uaFromURLString(urlString: string): string {
    if (!urlString.includes("||")) {
        return urlString
    }
    return urlString.split("||")[0]
}

export function chFromURLString(urlString: string): string | undefined {
    if (!urlString.includes("||")) {
        return undefined
    }
    return urlString.split("||")[1]
}

export function buildURLString(ua: string, ch?: string): string {
    if (!ch) {
        return ua
    }
    return ua + "||" + ch
}
