import OfficeLayout from "@/Layouts/OfficeLayout";
import FormGeneration from "../Components/FormGeneration";
import { useForm } from "react-hook-form";
import { Head, router, useForm as useFormInertial } from "@inertiajs/react";
import { useEffect } from "react";
import { Button, Label, Table } from "flowbite-react";
import Checkbox from "@/Components/Checkbox";

export default function PermissionDetail ({ role, permission, id }) {
    function edit() {
        router.get(route("permissions.edit", { id: id }));
    }

    return (
        <OfficeLayout>
            <Head title="Permission Detail" />
            <div className="mb-5 ml-2">
                Role name: <b className="text-transform: uppercase">{role.name}</b>
            </div>
            <Table>
                <Table.Head>
                    <Table.HeadCell>Name</Table.HeadCell>
                    <Table.HeadCell>Permission</Table.HeadCell>
                </Table.Head>
                <Table.Body className="divide-y">
                    {permission.map((item) => (
                        <Table.Row className="bg-white dark:border-gray-700 dark:bg-gray-800">
                            <Table.Cell className="whitespace-nowrap font-medium text-gray-900 dark:text-white text-transform: uppercase">
                                {item.name}
                            </Table.Cell>
                            <Table.Cell className="flex gap-x-10">
                                {item.action.map((action) => (
                                    <div className="flex gap-x-1 items-center">
                                        {action.hasPermission ? (
                                            <Checkbox checked disabled />
                                        ) : (
                                            <Checkbox disabled />
                                        )}

                                        <Label
                                            htmlFor="accept"
                                            className="flex text-transform: capitalize"
                                        >
                                            {action.name}
                                        </Label>
                                    </div>
                                ))}
                            </Table.Cell>
                        </Table.Row>
                    ))}
                </Table.Body>
            </Table>

            <div className="flex gap-5 mt-5">
                <Button color="warning" onClick={edit}>
                    Edit
                </Button>
                <Button onClick={() => history.back()}>Back</Button>
            </div>
        </OfficeLayout>
    );
}
