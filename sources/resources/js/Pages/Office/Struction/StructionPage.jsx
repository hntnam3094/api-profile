import { DeleteIcon, EditIcon, PlusIcon, ViewIcon } from "@/Icons";
import OfficeLayout from "@/Layouts/OfficeLayout";
import { Head, router } from "@inertiajs/react";
import { Table, Button } from "flowbite-react";
import HasLink from "../Components/HasLink";
import DefaultStatus from "../Components/Status/DefaultStatus";
import { dateTimeFormat } from "@/Constants/Common";
import HasPagination from "../Components/HasPagination";
export default function StructionPage({ data, islist, pageCode, code }) {

    function deleteStructionDetail(id) {
        if (confirm("Are you sure?") == true) {
            router.delete(route('structionpages.delete', {id: id}))
        }
    }

    return (
        <OfficeLayout>
            <Head title="Struction page" />
            {!islist && (
                <div className="mb-[20px] flex justify-end">
                    <HasLink
                        color="success"
                        link={route("structionpages.create", {
                            page_code: pageCode,
                            code: code,
                        })}
                    >
                        <PlusIcon />
                    </HasLink>
                </div>
            )}
            <div className="overflow-x-auto">
                <Table hoverable>
                    <Table.Head className="text-center">
                        <Table.HeadCell className="w-[30px]">ID</Table.HeadCell>
                        {islist == 1 && (
                            <>
                                <Table.HeadCell>Title</Table.HeadCell>
                                <Table.HeadCell>PageCode</Table.HeadCell>
                                <Table.HeadCell>Status</Table.HeadCell>
                            </>
                        )}

                        {!islist && (
                            <>
                                <Table.HeadCell>Status</Table.HeadCell>
                                <Table.HeadCell>Sequence</Table.HeadCell>
                                <Table.HeadCell>Created at</Table.HeadCell>
                            </>
                        )}

                        <Table.HeadCell className="w-[200px]">
                            Action
                        </Table.HeadCell>
                    </Table.Head>
                    <Table.Body className="divide-y">
                        {data.data.map((item, key) => (
                            <Table.Row
                                key={key}
                                className="bg-white dark:border-gray-700 dark:bg-gray-800 text-center"
                            >
                                <Table.Cell className="whitespace-nowrap font-medium text-gray-900 dark:text-white">
                                    {key + 1}
                                </Table.Cell>
                                {islist == 1 && (
                                    <>
                                        <Table.Cell>{item.title}</Table.Cell>
                                        <Table.Cell>{item.pageCode}</Table.Cell>
                                        <Table.Cell>{item.status}</Table.Cell>
                                    </>
                                )}

                                {!islist && (
                                    <>
                                        <Table.Cell><DefaultStatus value={item.status} /></Table.Cell>
                                        <Table.Cell>{item.sequence}</Table.Cell>
                                        <Table.Cell>
                                            {dateTimeFormat(item.created_at)}
                                        </Table.Cell>
                                    </>
                                )}

                                <Table.Cell className="flex gap-[5px] justify-center">
                                    <HasLink
                                        link={route("structionpages.detail", {
                                            id: item.id,
                                            is_list: islist
                                        })}
                                    >
                                        <ViewIcon />
                                    </HasLink>
                                    {!islist && (
                                        <HasLink
                                            link={route("structionpages.edit", {
                                                id: item.id
                                            })}
                                            color="warning"
                                        >
                                            <EditIcon />
                                        </HasLink>
                                    )}

                                    {!islist && (
                                        <Button link="#" className="bg-red-400" onClick={() => deleteStructionDetail(item.id)}>
                                            <DeleteIcon />
                                        </Button>
                                    )}
                                </Table.Cell>
                            </Table.Row>
                        ))}
                    </Table.Body>
                </Table>
                <div>
                    <HasPagination data={data} />
                </div>
            </div>
        </OfficeLayout>
    );
}
