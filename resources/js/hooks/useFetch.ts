import { useEffect, useState } from "react";

export function useData(url: string, refreshKey: number | null = null) {
    const [data, setData] = useState(null);
    useEffect(() => {
        let ignore = false;
        fetch(url, {
            credentials: "include", // セッションを利用するために必要,クッキーを送信できる。
        })
            .then((response) => response.json())
            .then((json) => {
                if (!ignore) {
                    setData(json);
                }
            });
        return () => {
            ignore = true;
        };
    }, [url, refreshKey]);
    return data;
}
