import { DeleteIcon, EditIcon, PlusIcon, ViewIcon } from "@/Icons";
import OfficeLayout from "@/Layouts/OfficeLayout";
import { Head, router } from "@inertiajs/react";
import { Table, Button } from "flowbite-react";
import HasLink from "../Components/HasLink";
import DefaultStatus from "../Components/Status/DefaultStatus";
import { dateTimeFormat } from "@/Constants/Common";
import HasPagination from "../Components/HasPagination";

export default function CategoryList({ data, posttype, form }) {
    function deleteStructionDetail(id) {
        if (confirm("Are you sure?") == true) {
            router.delete(route("category.delete", { id: id }));
        }
    }

    function renderField(obj, key, type) {
        if (type === 'image') {
            return <img src={`${obj[key]}`} className="w-[100%] h-[80px] rounded-sm object-cover" />;
        }
        return obj[key];
    }

    return (
        <OfficeLayout>
            <Head title="Struction page"  />
            <div className="mb-[20px] flex justify-end">
                <HasLink
                    color="success"
                    link={route("category.create", {
                        posttype: posttype,
                    })}
                >
                    <PlusIcon />
                </HasLink>
            </div>
            <div className="overflow-x-auto">
                <Table hoverable>
                    <Table.Head className="text-center">
                        <Table.HeadCell className="w-[30px]">ID</Table.HeadCell>
                        {form.category_list &&
                            form.category_list.length > 0 &&
                            form.category_list.map((itemList) => (
                                <Table.HeadCell>{itemList.name}</Table.HeadCell>
                            ))}
                        <Table.HeadCell>Status</Table.HeadCell>
                        <Table.HeadCell>Sequence</Table.HeadCell>
                        <Table.HeadCell>Created at</Table.HeadCell>

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
                                {form.category_list &&
                                    form.category_list.length > 0 &&
                                    form.category_list.map((itemList) => (
                                        <Table.Cell>
                                            {renderField(item, itemList.key, itemList.type)}
                                        </Table.Cell>
                                    ))}
                                <Table.Cell>
                                    <DefaultStatus value={item.status} />
                                </Table.Cell>
                                <Table.Cell>{item.sequence}</Table.Cell>
                                <Table.Cell>
                                    {dateTimeFormat(item.created_at)}
                                </Table.Cell>

                                <Table.Cell className="flex gap-[5px] justify-center">
                                    <HasLink
                                        link={route("category.detail", {
                                            id: item.id,
                                        })}
                                    >
                                        <ViewIcon />
                                    </HasLink>
                                    <HasLink
                                        link={route("category.edit", {
                                            id: item.id,
                                        })}
                                        color="warning"
                                    >
                                        <EditIcon />
                                    </HasLink>

                                    <Button
                                        link="#"
                                        className="bg-red-400"
                                        onClick={() =>
                                            deleteStructionDetail(item.id)
                                        }
                                    >
                                        <DeleteIcon />
                                    </Button>
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
