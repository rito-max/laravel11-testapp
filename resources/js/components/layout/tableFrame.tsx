import { ReactNode } from "react";

export default function TableFrame({
    headings,
    children,
}: {
    headings: Array<String>;
    children: ReactNode;
}) {
    return (
        <table className="text-center mx-auto w-5/6 mt-10">
            <thead>
                <tr>
                    {headings.map((head, index) => {
                        return (
                            <th
                                className="min-w-32 p-3 border-r-2 border-neutral-50"
                                key={index}
                            >
                                {head}
                            </th>
                        );
                    })}
                    <th className="min-w-32 p-3 border-neutral-50">操作</th>
                </tr>
            </thead>
            <tbody className="bg-neutral-50">{children}</tbody>
        </table>
    );
}
