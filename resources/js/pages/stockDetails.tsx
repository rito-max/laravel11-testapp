import { useContext, useState } from "react";
import ReactDOM from "react-dom/client";
import Button from "../components/ui/button";
import TableFrame from "../components/layout/tableFrame";
import { useData } from "../hooks/useFetch";
import Success from "../components/common/success";
import { sendDeleteRequest } from "../utils/postRequest";
import { IsEditorContext } from "../contexts/isEditorContext";
import Error from "../components/common/error";

const Transactions = () => {
    //削除した後一覧を再取得させるためのkey
    const [refreshKey, setRefreshKey] = useState(0);
    // transactionデータを取得
    const transactions: Array<TransactionProps> =
        useData(`/api/getTransaction?stock_id=${stockId}`, refreshKey) ?? [];
    const isEditor = useData("/api/getIsEditor") ?? false;
    const [errorMsg, setErrorMsg] = useState<string | null>(null);
    const [successMsg, setSuccessMsg] = useState<string | null>(null);

    async function handleDelete(props: TransactionProps) {
        //削除処理を実行
        const result = await sendDeleteRequest(
            `/api/deleteTransaction/${props.id}`
        );
        if (result) {
            setRefreshKey((prev) => prev + 1);
            setSuccessMsg(
                `取引ID: ${props.id} ${props.formatted_date} の取引履歴を削除しました。`
            );
            setTimeout(() => setSuccessMsg(null), 3000);
        } else {
            setErrorMsg(
                `取引ID: ${props.id} ${props.formatted_date} の取引履歴の削除に失敗しました。`
            );
            setTimeout(() => setErrorMsg(null), 3000);
        }
    }

    return (
        <IsEditorContext value={isEditor}>
            {successMsg && <Success message={successMsg} />}
            {errorMsg && <Error message={errorMsg} />}
            {isEditor && (
                <div className="text-right mx-auto w-5/6">
                    <Button
                        onClick={() =>
                            (window.location.href = `/stock/${stockId}/transaction/create`)
                        }
                        text="新規登録"
                        color="emerald-600"
                    />
                </div>
            )}
            <TableFrame headings={["取引日", "単価", "数量", "取引タイプ"]}>
                {transactions.map((data) => {
                    return (
                        <TransactionTr
                            {...data}
                            key={data.id}
                            handleDelete={handleDelete}
                        />
                    );
                })}
            </TableFrame>
        </IsEditorContext>
    );
};

type TransactionProps = {
    id: number;
    formatted_date: string;
    formatted_price: string;
    quantity: string;
    type_name: string;
    handleDelete: (props: TransactionProps) => void;
};

const TransactionTr = (props: TransactionProps) => {
    const isEditor = useContext(IsEditorContext);
    return (
        <tr>
            <td className="p-3 border-2 border-white">
                {props.formatted_date}
            </td>
            <td className="p-3 border-2 border-white">
                {props.formatted_price}
            </td>
            <td className="p-3 border-2 border-white">{props.quantity}</td>
            <td className="p-3 border-2 border-white">{props.type_name}</td>
            <td className="p-3 border-2 border-white">
                {isEditor ? (
                    <Button
                        onClick={() => props.handleDelete(props)}
                        text="削除"
                        color="red-400"
                    />
                ) : (
                    "-"
                )}
            </td>
        </tr>
    );
};

const rootElement = document.getElementById("transactions");
let stockId: null | string = null;
if (rootElement) {
    stockId = rootElement.getAttribute("data-stockid");
    ReactDOM.createRoot(rootElement).render(<Transactions />);
}
