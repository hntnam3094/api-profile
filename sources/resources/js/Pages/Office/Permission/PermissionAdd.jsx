import OfficeLayout from "@/Layouts/OfficeLayout";
import { Head, useForm  } from "@inertiajs/react";
import { Button, Label, Table } from "flowbite-react";
import Checkbox from "@/Components/Checkbox";

export default function PermissionAdd({ role, permission, id }) {

    const { data, setData, post, processing, errors } = useForm({
        permission: permission
    });

    const handleChecked = (e, index, actionIndex) => {
        let value = e.target.name ;
        if (data.permission[index].action[actionIndex]) {
            data.permission[index].action[actionIndex].hasPermission = value ?? false
            setData('permission', data.permission)
        }
    };

    function submit(e) {
        e.preventDefault();
        post(route('permissions.update', {
            id: id
        }))
    }

    return (
        <OfficeLayout>
            <Head title="Permission Detail" />
            <div className="mb-5 ml-2">
                Role name:{" "}
                <b className="text-transform: uppercase">{role.name}</b>
            </div>
            <form onSubmit={submit}>
                <Table>
                    <Table.Head>
                        <Table.HeadCell>Name</Table.HeadCell>
                        <Table.HeadCell>Permission</Table.HeadCell>
                    </Table.Head>
                    <Table.Body className="divide-y">
                        {permission.map((item, index) => (
                            <Table.Row key={index} className="bg-white dark:border-gray-700 dark:bg-gray-800">
                                <Table.Cell className="whitespace-nowrap font-medium text-gray-900 dark:text-white text-transform: uppercase">
                                    {item.name}
                                </Table.Cell>
                                <Table.Cell className="flex gap-x-10">
                                    {item.action.map((action, actionIndex) => (
                                        <div key={actionIndex} className="flex gap-x-1 items-center">

                                            <Checkbox defaultChecked={permission[index].action[actionIndex].hasPermission} onChange={e => handleChecked(e, index, actionIndex)} />

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

                <div className="flex gap-5">
                    <Button type="submit" color="success">
                        Submit
                    </Button>
                    <Button onClick={() => history.back()}>Back</Button>
                </div>
            </form>
        </OfficeLayout>
    );
}
