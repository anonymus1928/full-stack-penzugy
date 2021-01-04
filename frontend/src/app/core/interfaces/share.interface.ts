export interface Share {
    id: number;
    symbol: string;
    name: string;
    description: string;
    exchange: string;
    history: string;
    currency: string;
    country: string;
    sector: string;
    industry: string;
    address: string;
    full_time_employees: number;
    market_capitalization: number;
}

export interface History {
    date: string;
    high: number;
    low: number;
    open: number;
    close: number;
}