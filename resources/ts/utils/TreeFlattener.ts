export interface IFlatDataItem {
    id: string,
    url?: string
}
export interface IFlatData<T extends IFlatDataItem> {
    item: T;
    path: string[];
    level: number;
}

export interface ITreeData<T> extends IFlatDataItem {
    children?: T[];
}

export class TreeFlattener<T extends IFlatDataItem> {
    private _treeDataFlat: IFlatData<T>[] = [];
    private _path: string[] = [];

    constructor(treeData: ITreeData<T>[]) {
        this._flatTree(treeData);
    }

    get treeDataFlat() {
        return this._treeDataFlat;
    }

    private _flatTree(treeData: ITreeData<T>[]) {
        treeData.forEach((element, index) => {
            this._path.push(element.id);
            this._treeDataFlat.push(this._getTreeData(element));
        });
    }

    private _getTreeData(data: ITreeData<T>) {
        let dataCopy = { ...data };
        delete dataCopy.children;
        let flatData: IFlatData<T> = {
            item: dataCopy as T,
            path: [...this._path],
            level: 0
        };
        const hasChild = data?.children && data?.children?.length;
        if (hasChild) this._flatTree(data.children!);
        this._path.pop();
        flatData.level = flatData.path.length - 1;
        return flatData;
    }
}