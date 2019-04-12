export interface ParsedData {
    "isBot": boolean;
    "clientInfo": {
        "type": string,
        "name": string,
        "short_name": string,
        "version": string,
        "engine": string,
        "engine_version": string
    };
    "browserIcon": string | null;
    "osInfo": {
        "name": string,
        "short_name": string,
        "version": string,
        "platform": string
    };
    "osIcon": string | null;
    "device": number;
    "deviceName": string;
    "deviceIcon": string | null;
    "deviceBrand": string;
    "brandIcon": string | null;
    "model": string;
    "botInfo": {
        "name": string,
        "category": string,
        "url": string,
        "producer": {
            "name": string,
            "url": string
        }
    };
}

export interface Version {
    "commitHash": string;
    "date": string;
}

export interface SupportedList {
    "operatingSystems": string[];
    "browsers": string[];
    "engines": string[];
    "libraries": string[];
    "mediaPlayer": string[];
    "mobileApps": string[];
    "PIM": string[];
    "feedReaders": string[];
    "brands": string[];
    "bots": string[];
}
