import OfficeLayout from "@/Layouts/OfficeLayout";
import FormGeneration from "../Components/FormGeneration";
import { useForm } from "react-hook-form";
import { useForm as useFormInertial } from "@inertiajs/react";
import { useEffect } from "react";
import { Button } from "flowbite-react";

export default function UserAdd({ dataForm, form, id = 0 }) {

    const {
        register: registerRHF,
        handleSubmit: handleSubmitRHF,
        watch: watchRHF,
        control: controlRHF,
        unregister: unregisterRHF,
        setValue: setValueRHF,
    } = useForm({ defaultValues: dataForm });

    const { data, setData, post, errors } = useFormInertial();

    useEffect(() => {
        setData(buildStructionData(form.form, dataForm));
    }, [form.form]);

    useEffect(() => {
        watchRHF((value, { name, type }) => {
            setData(value);
        });
    }, [watchRHF]);

    function buildStructionData(structionForm, dataForm) {
        let obj = {};
        if (structionForm && structionForm.length > 0) {
            structionForm.forEach((ob, i) => {
                obj[ob.name] = dataForm[ob.name] ?? ob.value;
            });
        }

        return obj;
    }

    function onSubmit() {
        if (id) {
            post(
                route("user.update", {
                    id: id
                })
            );
        } else {
            post(route("user.store"));
        }
    }

    return (
        <OfficeLayout>
            <form onSubmit={handleSubmitRHF(onSubmit)}>
                <FormGeneration
                    form={form.form}
                    register={registerRHF}
                    watch={watchRHF}
                    control={controlRHF}
                    errors={errors}
                    unregister={unregisterRHF}
                    setValue={setValueRHF}
                    isEdit={id}
                />

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
