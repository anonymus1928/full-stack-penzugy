import { Category } from "./category.interface";

export interface Transaction {
    id: number;
    amount: number;
    name: string;
    description: string;
    due: string;
    categories: Category[];
}