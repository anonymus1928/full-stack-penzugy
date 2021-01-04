import { Share } from "./share.interface";

export interface Investment {
    id: number;
    price: number;
    amount: number;
    date: string;
    share: Share;
}