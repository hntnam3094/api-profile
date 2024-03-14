import OfficeLayout from "@/Layouts/OfficeLayout";
import { Table } from "flowbite-react";
import HasLink from "../Components/HasLink";
import { EditIcon, ViewIcon } from "@/Icons";
import { Head } from "@inertiajs/react";


export default function PermissionList ({role}) {
    return (
        <OfficeLayout>
            <Head title="Permission List" />
            <div className="overflow-x-auto">
                <Table hoverable>
                    <Table.Head className="text-center">
                        <Table.HeadCell className="w-[30px]">ID</Table.HeadCell>
                        <Table.HeadCell>Name</Table.HeadCell>

                        <Table.HeadCell className="w-[200px]">
                            Action
                        </Table.HeadCell>
                    </Table.Head>
                    <Table.Body className="divide-y">
                        {role.map((item, key) => (
                            <Table.Row
                                key={key}
                                className="bg-white dark:border-gray-700 dark:bg-gray-800 text-center"
                            >
                                <Table.Cell className="whitespace-nowrap font-medium text-gray-900 dark:text-white">
                                    {key + 1}
                                </Table.Cell>
                                <Table.Cell>
                                    {item.name}
                                </Table.Cell>

                                <Table.Cell className="flex gap-[5px] justify-center">
                                    <HasLink
                                        link={route("permissions.detail", {
                                            id: item.id,
                                        })}
                                    >
                                        <ViewIcon />
                                    </HasLink>
                                    <HasLink
                                        link={route("permissions.edit", {
                                            id: item.id,
                                        })}
                                        color="warning"
                                    >
                                        <EditIcon />
                                    </HasLink>
                                </Table.Cell>
                            </Table.Row>
                        ))}
                    </Table.Body>
                </Table>
            </div>
        </OfficeLayout>
    )
}
